<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
    public function User(){
        return $this->hasOne('\App\User','id','user');
    }
}
