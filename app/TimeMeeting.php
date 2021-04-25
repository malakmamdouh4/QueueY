<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeMeeting extends Model
{
    protected $table='time_meetings';
    protected $fillable =['time','created_at' ,'updated_at'];
    protected $hidden =[];

}
