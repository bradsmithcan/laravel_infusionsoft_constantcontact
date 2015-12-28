<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Team;
use App\Models\TeamInvitation;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Contracts\Routing\Registrar;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct(Guard $auth, Registrar $registrar)
    {
        
        $this->auth = $auth;
        $this->registrar = $registrar;
        $this->middleware('guest',
            ['except' =>
                ['getLogout', 'resendEmail', 'activateAccount']]);
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()){
            $this->throwValidationException(
                $request, $validator
            );
        }
        $activation_code = str_random(80);
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->activation_code = $activation_code;
        if($request->input('parent_user')){
            $user->parent_user = $request->input('parent_user');
            $user->save();
            $this->addToTeam($user, $user->parent_user);
        }
        if ($user->save()) {
//            $this->sendEmail($user);
            return view('auth.activateAccount')
                ->with('email', $request->input('email'));
        } else {
            \Session::flash('message', 'Your account could not be created; please try again.' );
            return redirect()->back()->withInput();
        }

    }

    public function sendEmail(User $user)
    {
        $data = array(
            'name' => $user->name,
            'code' => $user->activation_code,
        );

        \Mail::queue('emails.activateAccount', $data, function($message) use ($user) {
            $message->subject( 'Please activate your account.');
            $message->to($user->email);
        });
    }

    public function resendEmail(Request $request)
    {
        $email = $request->email;

        $rules = [
            'email' => 'required|exists:users,email'
        ];
        $this->validate($request, $rules);

        $user = User::where('email', '=', $email)->first();
        if( $user->resent >= 3 )
        {
            return view('auth.tooManyEmails')
                ->with('email', $user->email);
        } else {
            $user->resent = $user->resent + 1;
            $user->save();
            $this->sendEmail($user);
            return view('auth.activateAccount')
                ->with('email', $user->email);
        }
    }

    public function activateAccount($code, User $user)
    {
        if($user->accountIsActive($code)) {
            \Session::flash('message', 'Success, your account has been activated.');
            return redirect('/home');
        }

        if($user->parent_user){
            $team = Team::where('member_id', '=', $user->parent_user)->first();
            $team->status = 2;
            $team->save();
        }


        \Session::flash('message', 'Your account couldn\'t be activated, please try again');
        return redirect('/');

    }

    public function addToTeam(User $member, $parentUser){

        $teamInvitation = TeamInvitation::where('accept_email', '=', $member->email)->where('request_id', '=', $parentUser)->first();
        if(!$teamInvitation){
            die("Something went wrong.You have no invitation");
        }
        $userTeam = Team::where('member_id', '=', $parentUser)->first();

        if(!$userTeam){
            $userTeam = new Team();
            $userTeam->member_id = $parentUser;
            $userTeam->status = 2;
            $userTeam->save();
            $userTeam->team_id = $userTeam->id;
            $userTeam->save();
        }
        $teamId = $userTeam->team_id;
        $teamInvitation->status = 1;
        $teamInvitation->save();
        $team = new Team();
        $team->team_id = $teamId;
        $team->member_id = $member->id;
        $team->status = 1;//user is not activated
        $team->save();
    }
}
