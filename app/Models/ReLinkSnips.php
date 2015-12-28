<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReLinkSnips extends Model
{
    protected $table = 'relink_snips';

    protected $fillable = ['id','second','user_id','parent_id','page_url','short_link','title','descrip','api','upload_path','bg','type','btntxt','btnurl','title_color','descrip_color','btntxt_color'];
}
