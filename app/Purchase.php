<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{

  protected $fillable = ['user_id', 'supplier_id', 'total_price'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function userDes()
  {
    return $this->belongsTo(User::class)->orderBy('name');
  }


  public function supplier()
  {
    return $this->belongsTo(Supplier::class);

  }
  public function product()
  {
    // return $this->belongsTo('App\Product', 'foreign_key', 'lpcal_key');
    return $this->belongsTo('App\Product', 'product_code', 'product_code');
  }
  public function purchaseItems()
 {
   return $this->hasMany(PurchaseDetail::class)->with('product');
 }
}
