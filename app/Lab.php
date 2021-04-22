<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $fillable = [
      'day' , 'time' , 'active' , 'user_id' , 'created_at' , 'updated_at'
    ];
}
