<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReLinkClicks extends Model
{
    protected $table = 'relink_clicks';

    protected $fillable = ['id', 'relink_id', 'ip'];

    public function reLink()
    {
        return $this->belongsTo('App\Models\ReLink', 'id', 'relink_id');
    }
}
