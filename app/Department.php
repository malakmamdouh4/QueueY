<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table ='departments';
    protected $fillable =['name','image','created_at' ,'updated_at'];


    public function doctor(){
        return $this->hasMany('App\Doctor','department_id');
    }

}
