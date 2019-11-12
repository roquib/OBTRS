<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Publication;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PublicationController extends Controller
{
  public function index()
  {
    // return "get data";
    return Publication::latest()->paginate(10);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name'      => 'required|string|max:255|min:2',
    ]);

    return Publication::create([
      'name'         => $request['name'],
      'description'  => $request['description'],
    ]);
  }


  public function show($id)
  {
    //
  }

  public function update(Request $request, Publication $publication)
  {
    $this->validate($request, [
      'name'      => 'required|string|max:255|min:2',
    ]);

    $publication->update($request->all());
    return ['message' => 'Update successfull'];
  }

  public function destroy(Publication $publication)
  {
    $publication->delete();
    return ['message' => 'User deleted successfully'];
  }
}
