<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class plans extends Model
{
    public function plan_durations(){
        return $this->hasMany('\App\plan_durations','plan','id');
    }
}
