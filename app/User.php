<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function subscriptionOb(){
        return $this->hasOne('\App\subscriptions','user','id');
    }
    public function paymentsObjs(){
        return $this->hasMany('\App\payments','user','id');
    }
     public function bookingsObjs(){
        return $this->hasMany('\App\booking','user','id')->orderBy('id','DESC');
    }
     public function FreezedObj(){
        return $this->hasOne('\App\Freezed','user','id');
    }
    public static function boot() {
        parent::boot();

        static::deleting(function($user) { 
             $user->subscriptionOb()->delete();
             $user->bookingsObjs()->delete();
           
        });
    }
    
}
