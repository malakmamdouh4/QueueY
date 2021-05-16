<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name' , 'image','area_id' ,'user_id' , 'created_at' ,'updated_at'
        ];

    protected $hidden = [
        'area'  ,'area_id' , 'user_id' , 'created_at' ,'updated_at'//  hidden to get method 'ShowController@getService'
    ];


    public function area()
    {
        return $this->belongsTo('App\Models\Area','area_id');
    }

    public function time()
    {
        return $this->hasMany('App\Models\TimeLab','service_id');
    }

    public function meeting()
    {
        return $this->hasMany('App\Models\Meeting','service_id');
    }
}
