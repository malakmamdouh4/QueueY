<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLab extends Model
{
    protected $table ='time_labs';
    protected $fillable =['time','active','lab_id','user_id','created_at' , 'updated_at'];
    protected $hidden =['lab_id','created_at' , 'updated_at'];
    public function lab(){
    return $this->belongsTo('App\Models\Lab','lab_id');
    }
}
