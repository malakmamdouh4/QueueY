<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'value' , 'opinion' , 'user_id'
    ];

    public function user()
    {
        return $this->hasMany('App\Models\User','user_id');
    }
}
