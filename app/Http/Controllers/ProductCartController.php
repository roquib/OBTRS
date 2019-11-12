<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Author;
use App\Publication;
use Cart;

class ProductCartController extends Controller
{

    // get all cart product
    public function index() {
        return view('public_user.pages.cart.index',
        [
            'activePage'   => "",
            'cartProducts' => Cart::Content(),
            'authors'      => Author::orderBy('NAME', 'asc')->get(),
            'publications' => Publication::orderBy('NAME', 'asc')->get()
        ]);
    }


    // Product add into cart
    public function create($id) {
      $product    = Product::where('id', $id)->first();
      Cart::add(
        [
          'id'    => $id,
          'name'  => $product->name,
          'price' => $product->price,
          'image' => $product->image,
          'qty'   => 1
      ]);
      // reterun from where comes
      return redirect()->back();
    }


    // Remove or delete single item from cart
    public function removeCartItem($rowId) {
        if ($rowId) {
          Cart::remove($rowId);
        }
        return redirect()->back();
    }


    // Remove or Delete all cart
    public function destroyAllCart() {
        Cart::destroy();
        return redirect()->back();
    }


    // Update cart quantity
    public function updateCart(Request $request) {
        Cart::update($request->rowId, $request->qty);
        return redirect()->back();
    }

}
