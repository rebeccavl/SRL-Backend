<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesController extends Controller
{


  public function index()
  {
    $roles = Roles::all();
    return Response::json($roles);
  }


  public function store (Request $request)
  {
    $rules=[
      "username" => "required",
      "email" => "required",
      "password" => "required"
    ];
  $validator = Validator::make(Purifier::clean($request->all()), $rules);

  if($validator->fails())
  {
    return Response::json(["error"=>"please fill out all of the fields"]);
  }

  $user = Auth::user();
  if($user->roleID != 1)
  {
    return Response::json(["error" => "You can't enter here."]);
  }
}


  public function update($id, Request $request)
  {
    $role = Role::find($id);
    $role->title = $request->input('role');
    $role->save();
    return Response::json(["success"=>"Role Updated."]);
  }


  public function show($id)
  {
    $role = Article::find($id);
    return Response::json($role);
  }


  public function destroy($id)
  {
    $role = Role::find($id);
    $role->delete();
    return Response::json(['success' => 'Role deleted.']);
  }
}
