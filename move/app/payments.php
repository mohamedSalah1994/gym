<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    public function userObj(){
        return $this->hasOne('\App\User','id','user');
    }
    public function planOb(){
        return $this->hasOne('\App\plans','id','plan');
    }
      public function adminOb(){
        return $this->hasOne('\App\Admin','id','created_by');
    }
}
