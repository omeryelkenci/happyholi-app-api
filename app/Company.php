<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'name', 'phone', 'email', 'address', 'price', 'type'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function rates()
    {
        return $this->hasMany('App\CompanyRates');
    }
}
