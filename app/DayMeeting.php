<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayMeeting extends Model
{
    protected $table='day_meetings';
    protected $fillable =['day','created_at' ,'updated_at'];
    protected $hidden =[];
}
