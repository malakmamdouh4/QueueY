<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    protected $fillable = [
        'name' , 'destinationId' ,'userId' , 'created_at' ,'updated_at'
    ];

}
