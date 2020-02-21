<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    protected $guarded = [];

    protected $table = 'countries';
    public $timestamps=false;
}
