<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
      public function newsCount(){
        return $this->hasMany('App\Models\News','category_id','id')->where('status',1)->count();
      }
}
