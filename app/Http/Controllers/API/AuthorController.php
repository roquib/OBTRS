<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Author;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use DB;
// require 'vendor/autoload.php';

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Author::latest()->paginate(10);
        return DB::table('authors')->paginate(5);
    }
    public function author_list()
    {
        // return Author::latest()->paginate(10);
        return DB::table('authors')->orderBy('name', 'asc')->paginate(155);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'name'   => 'required|string|max:255|min:2',
        ]);
        $imgName = 'abc';
        if ($request->image ) {
          $imgName = time().'.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
          \Image::make($request->image)->save(public_path('img/writer/').$imgName);
        }


        // insert data
        return Author::create([
          'name'        => $request['name'],
          'image'       => $imgName,
          'description' => $request['description'],
          'more_about'  => $request['more_about']
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
      $author = Author::findOrFAil($id);
      $this->validate($request, [
        'name'   => 'required|string|max:255|min:2',
      ]);
      $imgName = '';
      $currentAuthor = Author::where('id', $id)->first();
      $currentImage = $currentAuthor->image;

      if ($request->image != $currentImage) {

        if ($request->image) {
          // return 'when change image: ' . $request->image;
          $imgName = time().'.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
          \Image::make($request->image)->save(public_path('img/writer/').$imgName);
          $request->merge(['image' => $imgName]);
          if(file_exists('img/writer/'.$currentImage)) {
            unlink('img/writer/'.$currentImage);
          }
        } else {
          // return 'when not change image: ' . $request->image;
        }
      } else {
        // return 'current image: ' . $currentImage;
      }
      // return $request->all();
      $author->update($request->all());
      return ['message'=>'Getting id is: ' . $id];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $currentAuthor = Author::where('id', $id)->first();
      $currentImage = $currentAuthor->image;
      if(file_exists('img/writer/'.$currentImage)) {
        unlink('img/writer/'.$currentImage);
      }
      $author = Author::findOrFail($id);
      $author->delete();
      return ['message' => 'Author deleted successfully'];
    }
}
