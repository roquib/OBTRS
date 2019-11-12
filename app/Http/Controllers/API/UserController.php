<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct() {
      $this->middleware('auth:api');
    }

    public function index()
    {
        // dd(auth('api')->user());
        return User::paginate(10);
    }

    public function store(Request $request)
    {
      $this->validate($request, [
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:191|unique:users',
        'password' => 'required|string|min:4|max:191',
        'type'     => 'required',
      ]);
      // insert data
      return User::create([
        'name'     => $request['name'],
        'email'    => $request['email'],
        'type'     => $request['type'],
        'mobile'   => $request['mobile'],
        'password' => Hash::make($request['password']),
      ]);
    }


    public function show($id)
    {
        // display single item detail
    }

    public function update(Request $request, $id)
    {
        // update data
        $user = User::findOrFAil($id);
        $this->validate($request, [
          'name'     => 'required|string|max:255',
          'email'    => 'required|string|email|max:191|unique:users,email,'.$user->id,
          'password' => 'sometimes|min:6|max:191',
          'type'     => 'required',
        ]);
        $user->update($request->all());
        return ['message'=>'Getting id is: ' . $id];
    }

    public function destroy($id)
    {
        // select id
        $user = User::findOrFAil($id);
        $user->delete();
        return ['message' => 'User deleted successfully'];
    }

    public function profile()
    {
        return auth('api')->user();
    }


}
