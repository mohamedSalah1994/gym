<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post_categories extends Model
{
     public function cat_obj(){
        return $this->hasOne('\App\categories','id','category');
    }
    public function post_obj(){
        return $this->hasOne('\App\posts','id','post');
    }
}
