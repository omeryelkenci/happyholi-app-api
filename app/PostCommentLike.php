<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCommentLike extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['post_comment_id', 'like'];

    public function post_comment()
    {
        return $this->belongsTo('App\PostComment');
    }
}
