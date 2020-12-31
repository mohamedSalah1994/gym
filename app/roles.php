<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\role_permissions;
class roles extends Model
{
    public function permissions(){
        return $this->hasMany('\App\role_permissions','role','id');
    }
    public function checkRelatedPermision($permission){
        $check = role_permissions::where('role',$this->id)->where('permission',$permission)->first();
        return ($check) ? true : false ;
    }
}
