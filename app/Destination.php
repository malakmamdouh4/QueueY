<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
       'name' ,'user_id' , 'created_at' ,'updated_at'
    ];

    protected $hidden = [
        'user'  //  hidden to get method 'ShowController@getDestinationById'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function area()
    {
        return $this->hasMany('App\Area','destination_id');
    }
}
