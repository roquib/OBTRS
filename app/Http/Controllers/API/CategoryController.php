<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use DB;

class CategoryController extends Controller
{
  public function index()
  {
    return Category::latest()->paginate(5);
  }

  public function category_list()
  {
    return DB::table('categories')->paginate(255);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name'         => 'required|string|max:255|min:2',
      'description'  => 'required|string|min:4|max:191',
    ]);
    // insert data
    return Category::create([
      'name'         => $request['name'],
      'description'  => $request['description'],
    ]);
  }


  public function show($id)
  {
    // display single item detail
  }

  public function update(Request $request, Category $category)
  {
    $this->validate($request, [
      'name'         => 'required|string|max:255|min:2',
      'description'  => 'required|string|min:4|max:191',
    ]);

    $category->update($request->all());
    return ['message' => 'Category updated successfull'];
  }

  public function destroy(Category $category)
  {
    $category->delete();
    return ['message' => 'Category deleted successfully'];
  }
}
