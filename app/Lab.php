<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $table ='labs';
    protected $fillable = [
      'day' , 'created_at' , 'updated_at'
    ];
    protected $hidden =['created_at' ,'updated_at','id'];

    public function timeLab(){
        return $this->hasMany('App\TimeLab','lab_id');
    }
}
