<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeMeeting extends Model
{
    protected $table='time_meetings';
    protected $fillable =['time','active','day_meeting_id','created_at' ,'updated_at'];
    protected $hidden =['day','created_at' ,'updated_at'];

    public function day()
    {
        return $this->belongsTo('App\Models\DayMeeting','day_meeting_id');
    }

    public function meeting()
    {
        return $this->hasMany('App\Models\Meeting','time_meeting_id');
    }

}
