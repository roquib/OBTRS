<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
  protected $fillable = [
    'id'
  ];
  public function boardingPoints()
  {
    return $this->hasMany('App\Boarding');
  }
  public function dropingPoints()
  {
    return $this->hasMany('App\Droping');
  }
}
