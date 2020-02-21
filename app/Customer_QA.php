<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_QA extends Model
{
   protected $table = 'customer_q_a';
  protected $fillable = ['user_id','product_id','question','answer','answer_date'];
  
}
