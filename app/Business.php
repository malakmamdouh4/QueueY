<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'fullName', 'email' , 'password', 'created_at' ,'updated_at'
    ];
}
