<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;
use JWTAuth;
use Auth;

class ProductsController extends Controller
  {
    public function index()
    {
    $products = Product::all();
    return Response::json($products);
    }
public function store(Request $request)

  $rules = [
    'title' => 'required',
    'description' => 'required',
    'image' => 'required'
    ];

  $validator = Validator::make(Purifier::clean($request->all()), $rules);

  if($validator->fails())
    {
    return Response::json(["error" => "Please fill out all fields."]);
    }

  $user = Auth::user();
  if($user->roleID != 1)
    {
    return Response::json(["error" => "You are not authorized to add a product."]);
    }

  $products = new Product;

  $products->title = $request->input('title');
  $products->description = $request->input('description');

  $image = $request->file('image');
  $imageName= $image->getClientOriginalName();
  $image->move('storage/',$imageName);
  $products->image = $request->root()."/storage/".$imageName;
  $products->save();

  return Response::json(["success" => "Product successfully added."]);
  }

  public function update($id, Request $request)
  {
    $products = Product::find($id);

    $products->title = $request->input('title');

    $products->description = $request->input('description');

    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $image->move("storage/",$imageName);
    $products->image = $request->root(). "/storage/".$imageName;

    $products->save();

    return Response::json(["success"=>"Product Updated."]);
    }

    public function show($id)
    {
      $products = Product::find($id);

      return Response::json($products);
    }


    public function destroy($id)
    {
      $products = Product::find($id);

      $products->delete();

      return Response::json(['success' => 'Deleted Article.']);
    }
}
