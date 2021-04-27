<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table='meetings';
    protected $fillable =['name','idNumber','topic','day_meeting_id','time_meeting_id','user_id','doctor_id','created_at' ,'updated_at'];
    protected $hidden =[];

    public function user()
    {
        return $this->hasMany('App\Models\User','user_id');
    }

    public function doctor()
    {
        return $this->hasMany('App\Models\Doctor','doctor_id');
    }

    public function day()
    {
        return $this->hasMany('App\Models\DayMeeting','day_meeting_id');
    }

    public function time()
    {
        return $this->hasMany('App\Models\TimeMeeting','time_meeting_id');
    }


}
