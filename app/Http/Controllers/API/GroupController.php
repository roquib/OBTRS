<?php


namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Group;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
  public function index()
  {
      // load page with initial data
      return Group::latest()->paginate(10);
  }

  public function store(Request $request)
  {
    // dd($request->all());
    // validation
    $this->validate($request, [
      'name'      => 'required|string|max:255|min:2',
    ]);
    // insert data
    return Group::create([
      'name'      => $request['name'],
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
         // update data
         $group = Group::findOrFAil($id);
         $this->validate($request, [
           'name'      => 'required|string|max:255|min:2',
         ]);
         $group->update($request->all());
         return ['message'=>'Getting id is: ' . $id];
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      Group::findOrFail($id)->delete();
      return ['message' => 'Group deleted successfully'];
    }
}
