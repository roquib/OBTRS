<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = [
      'name', 'description'
  ];
  protected $hidden = [
      'remember_token',
  ];

  public function product() {
    return $this->hasMany('App\Author');
  }
}
