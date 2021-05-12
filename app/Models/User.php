<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable , HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullName', 'email', 'phone' , 'password', 'title' , 'busName' ,'busCategory' ,
        'busPhone' , 'busWebsite' , 'busEmail' , 'role' , 'busUpgrade' , 'avatar' , 'code' , 'created_at' ,'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }


    public function destination(){
        return $this->hasMany('App\Models\Destination','user_id');
    }

    public function meeting()
    {
        return $this->belongsTo('App\Models\Meeting','user_id');
    }


    public function affair()
    {
        return $this->belongsTo('App\Models\Affair','user_id');
    }


    public function problem()
    {
        return $this->belongsTo('App\Models\Problem','user_id');
    }

    public function rate()
    {
        return $this->belongsTo('App\Models\Rate','user_id');
    }
}
