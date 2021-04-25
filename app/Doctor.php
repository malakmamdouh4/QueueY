<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table='doctors';
    protected $fillable =['name','department_id','created_at' ,'updated_at'];
    protected $hidden =['department_id','department'];

    public function department(){
        return $this->belongsTo('App\Department','department_id');
    }
}
