<?php
namespace App;

class Cart
{
  public $items = null;
  public $totalQty = 0;
  public $totalPrice = 0;


  function __construct($oldCart)
  {
    if ($oldCart) {
      $this->items = $oldCart->items;
      $this->totalQty = $oldCart->totalQty;
      $this->totalPrice = $oldCart->totalPrice;
    }
  }

  public function add($item, $id) {
    $storedItem = ['qty' => 0, 'price' => $item->price, 'name' => $item->name, 'image' => $item->image, 'item'=>$item];
    if($this->items) {
      if (array_key_exists($id, $this->items)) {
        $storedItem = $this->items[$id];
      }
    }
    $storedItem['qty']++;
    $storedItem['price'] = $item->price * $storedItem['qty'];
    $storedItem['name'] = $item->name;
    $storedItem['image'] = $item->image;
    $this->items[$id] = $storedItem;
    $this->totalQty++;
    $this->totalPrice += $item->price;
  }





  public function remove($id) {
      // unset($this->items);
        if(!$this->items || !$this->items[$id]) {
            return false;  // maybe throw an exception here?
        }

        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -=  $this->items[$id]['price'] * $this->items[$id]['qty'];

    }

}
