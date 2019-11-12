<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
  protected $fillable = [
      'name', 'mobile', 'email', 'address'
  ];

  public function product() {
    return $this->hasMany('App\Product');
  }
}
