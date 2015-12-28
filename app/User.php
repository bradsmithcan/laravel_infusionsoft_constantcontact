<?php

namespace App;

use App\Models\Plan;
use App\Models\TeamInvitation;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Team;
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','name', 'email', 'password', 'first', 'last', 'paid', 'activation', 'parent_user',
        'type', 'activation_code', 'resent', 'archive', 'profile_count', 'friends_count', 'p_reset','twitter_id','facebook_id', 'plan_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function accountIsActive($code) {
        $user = User::where('activation_code', '=', $code)->first();
        if($user){
            $user->activation = 1;
            $user->activation_code = '';
            $user->type = 4;
            $user->save();
            if($user->parent_user){
                $teamMember = Team::where('member_id', '=', $user->id)->first();
                $teamMember->status = 2;
                if($teamMember->save()){
                    $teamInvaiteMember =  TeamInvitation::where('accept_email', '=', $user->email)->first();
                    $teamInvaiteMember->delete();
                }
            }
            if($user->save()) {
                \Auth::login($user);
            }
            return true;
        }
        return false;
    }

    public function isAdmin(){
        return ($this->type == 3 ? true : false );

    }

    public function notFree(){
        return ($this->type == 4 ? false : true );
    }


    public function isActive(){
        return ($this->activation == 1 ? true : false );
    }

    public function isNotChild(){
        return ((!isset($this->parent_user) || empty($this->parent_user)) ? true : false );
    }

    /**
     * User belongs to a Plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan(){
        return $this->belongsTo(Plan::class);
    }
}
