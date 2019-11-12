<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  protected $fillable = [
      'name'
  ];
  protected $hidden = [
      'remember_token',
  ];

  public function product() {
    return $this->hasMany('App\Product');
  }
}
