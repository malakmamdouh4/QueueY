<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affair extends Model
{

    protected $fillable =['name','idNumber','email','inquiry','user_id','area_id'];


    public function user()
    {
        return $this->hasMany('App\Models\User','user_id');
    }


    public function area()
    {
        return $this->belongsTo('App\Models\Area','area_id');
    }


}
