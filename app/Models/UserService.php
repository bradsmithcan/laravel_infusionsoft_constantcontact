<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'as_user_services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['api_id', 'user_id', 'thekey', 'list', 'compaign_id', 'app_id', 'api_username', 'api_password', 'additional'];

    public function api()
    {
        return $this->hasMany('App\Models\Api', 'id', 'api_id');
    }

}

