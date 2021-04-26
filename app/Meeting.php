<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table='meetings';
    protected $fillable =['name','idNumber','topic','dayMeeting_id','timeMeeting_id','user_id','doctor_id','created_at' ,'updated_at'];
    protected $hidden =[];
}
