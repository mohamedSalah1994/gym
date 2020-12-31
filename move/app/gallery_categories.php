<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gallery_categories extends Model
{
    public function gallerys(){
        return $this->hasMany('App\gallery','category','id');
    }
}
