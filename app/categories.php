<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    public function posts(){
        return $this->hasMany('\App\post_categories','category','id');
    }
}
