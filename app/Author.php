<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
  protected $fillable = [
      'name', 'title', 'image','description','more_about'
  ];
  protected $hidden = [
      'remember_token',
  ];

  public function product() {
    return $this->hasMany('App\Author');
  }
}
