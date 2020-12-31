<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post_tags extends Model
{
    public function tag_obj(){
        return $this->hasOne('\App\tags','id','tag');
    }
}
