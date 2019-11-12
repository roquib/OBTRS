<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
      'type', 'order_id', 'status', 'amount', 'transaction_id'
    ];
}
