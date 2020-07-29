<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function Categorycount(){


        return $this->hasMany('App\Models\Yazilar','category_id','id')->where('status',1)->count();
    }
}
