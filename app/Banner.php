<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    

  protected $table = 'banner';
   protected $fillable = ['banar_image','banar_text','banar_url'];
}