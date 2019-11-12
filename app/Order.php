<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $fillable = [
    'user_id',
    'email',
    'name',
    'mobile',
    'total_price',
    'tax',
    'shipping_cost',
    'contact_person',
    'contact_mobile',
    'zone',
    'address',
    'status',
    'feedback',
  ];

  public function product()
  {
    return $this->belongsTo('App\Product');
  }
  public function orderedProduct()
  {
    return $this->hasMany('App\OrderDetail');
  }
}
