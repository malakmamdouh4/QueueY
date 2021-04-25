<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeLab extends Model
{
    protected $table ='time_labs';
    protected $fillable =['value','active','lab_id','user_id','created_at' , 'updated_at'];
    protected $hidden =['lab_id','created_at' , 'updated_at'];
    public function lab(){
    return $this->belongsTo('App\Lab','lab_id');
    }
}
