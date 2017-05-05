<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesController extends Controller
{
  public function index()
  {
    $roles = roles::all();
    return Response::json($roles);
  }

  public function
  {
    
  }
