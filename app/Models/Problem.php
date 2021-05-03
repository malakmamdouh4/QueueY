<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $fillable = [
        'comment' ,
        'image' ,
        'user_id',
    ];

    public function user()
    {
        return $this->hasMany('App\Models\User','user_id');
    }

}
