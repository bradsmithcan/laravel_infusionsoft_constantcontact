<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrowBar extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'growbars';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cd', 'cdlc', 'user_id', 'type', 'website', 'link_url', 'openin', 'headline', 'link_text', 'font_family', 'background_color',
        'text_color', 'action_color', 'action_text_color', 'cdbg', 'cdtext', 'position', 'size', 'animate', 'wiggle', 'hidebar', 'push', 'hash', 'api_id'];


}
