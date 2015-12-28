<?php

namespace App\Http\Controllers;

use App\Models\TeamInvitation;
use App\Models\Team;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;

class TeamController extends Controller
{
    public function index()
    {
        $team_members = User::where('parent_user', '=', \Auth::user()->id)->get();
        $invited_members = TeamInvitation::where('request_id', '=', \Auth::user()->id)->get();
        return view('team.index', compact('team_members', 'invited_members'));
    }


    public function invite(Request $request)
    {
        $limits = array(0, 2, 3, 99999999999, 0);
        $user = $request->user();
        $userId = $user->id;
        $userRole = $user->type;
        /**
         * Check if user has right to invite.
         * User has right if has no parent_user, has available limit and inviting email not registered
         */
        if($user->parent_user){
            $request->session()->flash('error', "Sorry you have no right to create team.");
            return redirect('team');
        }

        $email = $request->get('email');
        $member = User::where('email', '=', $email)->first();
        if($member){
            if(!$member->activation){
                $request->session()->flash('error', "The invitation is already sent");
                return redirect('team');
            }
            $request->session()->flash('error', "Sorry, you can't send request to registered users.");
            return redirect('team');
        }else{
            $member = TeamInvitation::where('accept_email', '=', $request->get('email'))->first();
            if($member){
                $request->session()->flash('error', "Sorry, you can't send request to invited user.");
                return redirect('team');
            }
        }

        $existingMembers =  Team::where('member_id', '=', $userId)->get();
        $expiredLimit = count($existingMembers)-1;
        $invitedMembers = TeamInvitation::where('request_id', '=', $userId)->get();
        $expiredLimit += count($invitedMembers);
        if($limits[$userRole] <= $expiredLimit ){
            $request->session()->flash('error', "Sorry, your limit is expired.");
            return redirect('team');
        }elseif( $request->user()->type == 4 || $request->user()->parent_user  ){
            $request->session()->flash('error', "you can't invite team members");
            return redirect('team');
        }

        /**
         * Need create record in team_invitation
         */
        $teamInvitation = new TeamInvitation();
        $teamInvitation->request_id = $userId;
        $teamInvitation->request_user_email = $user->email;
        $activationCode = str_random(80);
        $teamInvitation->accept_id = $activationCode;
        $teamInvitation->accept_email = $email;
        $teamInvitation->status = 0;
        $teamInvitation->save();

        /**
         * Sending invitation email
         */
//        $this->sendEmail($user->name, $user->email, $activationCode);

        $request->session()->flash('message', "Invitation successfully sent.");
        return redirect('team');
    }


    public function acceptInvitation($code)
    {
        $teamInvitation = TeamInvitation::where('accept_id', '=', $code)->first();
        if(!$teamInvitation){
                die("Something went wrong.");
        }
        return view('auth.register')->with('email', $teamInvitation->accept_email)->with('parent_user', $teamInvitation->request_id);
    }

    public function sendEmail($userName, $userEmail, $activationCode)
    {
        $data = array(
            'name' => $userName,
            'code' => $activationCode,
        );

        \Mail::queue('emails.inviteTeamMember', $data, function($message) use ($userEmail) {
            $message->subject( 'Please activate invitation.');
            $message->to($userEmail);
        });
    }
}
