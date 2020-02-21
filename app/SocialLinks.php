<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialLinks extends Model
{
    

  protected $table = 'social_link';
  protected $fillable = ['facebook','twitter','pinterest','instagram','google'];
}