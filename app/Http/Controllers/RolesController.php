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
  }
