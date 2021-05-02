<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name' , 'area_id' ,'user_id' , 'created_at' ,'updated_at'
        ];

    protected $hidden = [
        'area' //  hidden to get method 'ShowController@getService'
    ];


    public function area()
    {
        return $this->belongsTo('App\Models\Area','area_id');
    }
}