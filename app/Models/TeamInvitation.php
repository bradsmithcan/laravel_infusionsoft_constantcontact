<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamInvitation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'team_invitation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['request_id','request_user_email','accept_id', 'accept_email', 'status'];


}