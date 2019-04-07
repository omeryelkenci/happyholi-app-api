<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'place_id', 'title', 'description', 'img_url', 'latitude', 'longitude'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    public function post_comments()
    {
        return $this->hasMany('App\PostComment');
    }

    public function post_like()
    {
        return $this->hasOne('App\PostLike');
    }
}
