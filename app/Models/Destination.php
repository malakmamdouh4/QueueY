<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
       'name' ,'image', 'user_id' , 'created_at' ,'updated_at'
    ];

    protected $hidden = [
        'user'  //  hidden to get method 'ShowController@getDestinationById'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function area()
    {
        return $this->hasMany('App\Models\Area','destination_id');
    }
}
