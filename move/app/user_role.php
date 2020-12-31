<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_role extends Model
{
     public function roleObj(){
        return $this->hasOne('\App\roles','id','role');
    }
}
