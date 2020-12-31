<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    public function post_tags(){
       return $this->hasMany('\App\post_tags','post','id');
    }
    public function post_cats(){
       return $this->hasMany('\App\post_categories','post','id');
    }
    
}
