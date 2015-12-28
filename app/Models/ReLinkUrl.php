<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReLinkUrl extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'relinks_url';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','relink_id','redirect_url'];

    public function reLink()
    {
        return $this->belongsTo('App\Models\ReLink', 'id', 'relink_id');
    }
}
