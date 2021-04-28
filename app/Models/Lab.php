<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $table ='labs';
    protected $fillable = [
      'date','day' , 'created_at' , 'updated_at'
    ];
    protected $hidden =['created_at' ,'updated_at','id'];

    public function timeLab(){
        return $this->hasMany('App\Models\TimeLab','lab_id');
    }
}
