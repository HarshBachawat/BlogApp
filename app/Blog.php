<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['title','cover_img','user_id','category_id','content'];

    public function category() {
    	return $this->belongsTo('App\Category','category_id');
    }

    public function author() {
    	return $this->belongsTo('App\User','user_id');
    }
}
