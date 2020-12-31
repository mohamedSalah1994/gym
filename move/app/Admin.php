<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\role_permissions;
class Admin extends Authenticatable
{
    
    public function role(){
        return $this->hasOne('\App\user_role','user','id');
    }
    public function checkPermission($permession){
        $check = role_permissions::where('role',$this->role->role)->where('permission',$permession)->first();
        return ($check) ? true : false;
    }
}
