<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayMeeting extends Model
{
    protected $table='day_meetings';
    protected $fillable =['day','active','created_at' ,'updated_at'];
    protected $hidden =['id','active','created_at','updated_at'];

    public function time()
    {
        return $this->hasMany('App\Models\TimeMeeting','day_meeting_id');
    }

    public function meeting()
    {
        return $this->belongsTo('App\Models\Meeting','day_meeting_id');
    }
}
