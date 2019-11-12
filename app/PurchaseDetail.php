<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $fillable = ['purchase_id', 'quantity', 'price', 'book_id'];

    // relation with product
  public function product()
  {
    return $this->hasOne('App\Product', 'id', 'book_id');
  }
  public function purchase()
  {
    return $this->belongsTo(Purchase::class, 'id');
  }
}
