<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReLink extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'relinks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','user_id','title','slug','short_link','redirect_url','code'];

    public function reLinkClicks()
    {
        return $this->hasMany('App\Models\ReLinkClicks', 'relink_id', 'id');
    }

}
