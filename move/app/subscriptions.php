<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscriptions extends Model
{
    public function planOb(){
        return $this->hasOne('\App\plans','id','plan');
    }
    public function User(){
        return $this->hasOne('\App\User','id','user');
    }
}
