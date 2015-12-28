<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'apis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function userService()
    {
        return $this->belongsTo('App\Models\UserService', 'api_id', 'id');
    }

}
