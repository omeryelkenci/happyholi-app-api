<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'from', 'to', 'text', 'type', 'is_read'];

    public function from()
    {
        return $this->belongsTo('App\User', 'from');
    }

    public function to()
    {
        return $this->belongsTo('App\User', 'to');
    }
}
