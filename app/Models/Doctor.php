<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table='doctors';
    protected $fillable =['name','department_id','image','created_at' ,'updated_at'];
    protected $hidden =['department_id','department'];

    public function department()
    {
        return $this->belongsTo('App\Models\Department','department_id');
    }

    public function meeting()
    {
        return $this->belongsTo('App\Models\Meeting','doctor_id');
    }
}
