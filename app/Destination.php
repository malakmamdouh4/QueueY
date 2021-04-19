<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
       'name' ,'userId' , 'created_at' ,'updated_at'
    ];
}
