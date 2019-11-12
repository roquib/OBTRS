<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class ProductController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api');
  }
  /**
   * Select the data from database and return to request page
   */
  public function index()
  {
    // $products = Product::latest()->paginate(3);
    $products = Product::with('author')
      ->with('category')
      ->with('group')
      ->paginate(5);
    return $products;
    dd($products);
  }

  public function product_list()
  {
    return DB::table('products')
      ->get(['name', 'price', 'id']);
  }

  public function search($prduct_search)
  {
    // return $search;
    if ($prduct_search == "") {
      $products = Product::with('author')
        ->with('category')
        ->with('group')
        ->paginate(5);
      return $products;
    }
    $products = Product::with('author')
      ->with('category')
      ->with('group')
      ->with('publication')
      ->where('name', 'like', '%' . $prduct_search . '%')
      ->paginate(5);
    return $products;
  }

  /**
   * Store the request data into database
   */
  public function store(Request $request)
  {
    $user_id = auth('api')->user()->id;
    $this->validate($request, [
      'name'               => 'required|string|max:255|min:2|unique:products',
      'category_id'        => 'required',
      'price'              => 'required',
      'qty'                => 'required',
      'author_id'          => 'required',
      'publication_status' => 'required'
    ]);

    $offer = 0;
    if ($request->offer != null) {
      $offer = $request->offer;
    }

    $imgName = 'abc';
    if ($request->image) {
      $imgName = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
      \Image::make($request->image)->save(public_path('product/') . $imgName);
    } else {
      $imgName = 'no_image';
    }
    // insert data
    return Product::create([
      'name'               => $request['name'],
      'group_id'           => $request['group_id'],
      'category_id'        => $request['category_id'],
      'price'              => $request['price'],
      'qty'                => $request['qty'],
      'offer'              => $offer,
      'isbn_no'            => $request['isbn_no'],
      'admin_id'           => $user_id,
      'author_id'          => $request['author_id'],
      'publication_id'     => $request['publication_id'],
      'publication_status' => $request['publication_status'],
      'image'              => $imgName,
      'description'        => $request['description']
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $product = Product::findOrFAil($id);


    // return 'got the request';
    $this->validate($request, [
      'name'               => 'required|string|max:255|min:2',
      'category_id'        => 'required',
      'price'              => 'required|integer|not_in:0',
      'qty'                => 'required|integer|not_in:0',
      'author_id'          => 'required',
      'publication_status' => 'required',
    ]);

    $imgName = 'abc';
    $currentProduct = Product::where('id', $id)->first();
    $currentImage = $currentProduct->image;

    if ($request->image != $currentImage) {

      if ($request->image) {
        $imgName = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
        \Image::make($request->image)->save(public_path('product/') . $imgName);
        $request->merge(['image' => $imgName]);
        if (file_exists('product/' . $currentImage)) {
          unlink('product/' . $currentImage);
        }
      } else {
        $request->merge(['image' => $imgName]);
        // return 'when not change image: ' . $request->image;
      }
    } else {
      $request->merge(['image' => $currentImage]);
    }
    // dd($request->all());
    // return $request->all();
    $product->update($request->all());
    return ['message' => 'Getting id is: ' . $id];
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

    $currentProduct = Product::where('id', $id)->first();
    $currentImage = $currentProduct->image;
    if (file_exists('product/' . $currentImage)) {
      unlink('product/' . $currentImage);
    }
    $product = Product::findOrFail($id);
    $product->delete();
    // redirect back
    return ['message' => 'Product deleted successfully'];
  }
}
