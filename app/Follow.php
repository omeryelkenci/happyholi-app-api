<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follow extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'from', 'to', 'follow'];

    public function follow()
    {
        return $this->belongsTo('App\User', 'from');
    }

    public function follower()
    {
        return $this->belongsTo('App\User', 'to');
    }
}
