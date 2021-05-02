<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    protected $fillable = [
        'image' , 'destination_id' ,'user_id' , 'created_at' ,'updated_at'
    ];

    protected $hidden = [
        'destination'  //  hidden to get method 'ShowController@getArea'
    ];



    public function destination()
    {
        return $this->belongsTo('App\Models\Destination','destination_id');
    }

    public function service()
    {
        return $this->hasMany('App\Models\Service','area_id');
    }

    public function affair()
    {
        return $this->belongsTo('App\Models\Affair','area_id');
    }


}
