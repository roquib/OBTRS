<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
      'order_id',
      'product_id',
      'quantity',
      'price',
      'offer',
    ];

    public function order() {
      return $this->belongsTo('App\Order');
    }
    public function product() {
      return $this->hasOne('App\Product');
    }
}
