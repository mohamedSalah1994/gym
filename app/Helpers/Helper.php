<?php
use App\permissions;
if (!function_exists('checkRole')) {
    function checkRole($permession)
    {

       $checkPermission = permissions::where('route',$permession)->first();
        if($checkPermission){
            $checkAllow = auth()->guard('admin')->user()->checkPermission($checkPermission->id);
            if(!$checkAllow && auth()->guard('admin')->user()->role->role != 1){
                return false;
            }else{
                return true;
            }
        }
            
    }
}