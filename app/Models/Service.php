<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name' , 'area_id' ,'user_id' , 'created_at' ,'updated_at'
        ];

    protected $hidden = [
        'area' , 'id' ,'area_id' , 'user_id' , 'created_at' ,'updated_at'//  hidden to get method 'ShowController@getService'
    ];


    public function area()
    {
        return $this->belongsTo('App\Models\Area','area_id');
    }

    public function time()
    {
        return $this->hasMany('App\Models\TimeLab','service_id');
    }
}
