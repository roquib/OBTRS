<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $fillable = [
      'company_logo_url',
      'company_name',
      'company_short_name',
      'company_address',
      "address_line1",
      "address_line2",
      "postal_code",
  ];

  public function detail() {
    return $this->hasMany('App\Detail');
  }
}
