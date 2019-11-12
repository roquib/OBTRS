<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = [
      'name',
      'group_id',
      'category_id',
      'price',
      'qty',
      'sold',
      'islamic',
      'offer',
      'isbn_no',
      'admin_id',
      'author_id',
      'publication_id',
      'publication_status',
      'image',
      'description'
  ];
  protected $hidden = [
      'remember_token',
  ];


  public function author() {
    return $this->belongsTo('App\Author');
  }
  public function category() {
    return $this->belongsTo('App\Category');
  }
  public function group() {
    return $this->belongsTo('App\Group');
  }
  public function publication() {
    return $this->belongsTo('App\Publication');
  }
  // relation with purchase detail
  public function purchases()
  {
    return $this->belongsTo(PurchaseDetail::class);
  }
}
