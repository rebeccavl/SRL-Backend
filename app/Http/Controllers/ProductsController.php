<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
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
{
  $rules=[
    'name' => 'required',
    'description' => 'required',
    'image' => 'required',
    'price' => 'required',
    'quantity' => 'required',
    'availability' => 'required'
    ];

  $validator = Validator::make(Purifier::clean($request->all()), $rules);

  if($validator->fails())
    {
    return Response::json(["error" => "Please fill out all fields."]);
    }

  $products = new Product;

  $products->name = $request->input('name');
  $products->description = $request->input('description');
  $products->categoryID = $request->input('categoryID');
  $products->price = $request->input('price');
  $products->quantity = $request->input('quantity');
  $products->availability = $request->input('availability');
  $products->productsID = $request->input('productsID');

  $image = $request->file('image');
  $imageName= $image->getClientOriginalName();
  $image->move('storage/',$imageName);
  $products->image = $request->root()."/storage/".$imageName;
  $products->save();

  return Response::json(["success" => "Product successfully added."]);
  }


  public function update($id, Request $request)
  {
    $rules=[
      'name' => 'required',
      'description' => 'required',
      'image' => 'required',
      'price' => 'required',
      'quantity' => 'required',
      'availability' => 'required'
      ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
      {
      return Response::json(["error" => "Please fill out all fields."]);
      }

    $products = Product::find($id);

    $products->name = $request->input('name');
    $products->description = $request->input('description');
    $products->categoryID = $request->input('categoryID');
    $products->price = $request->input('price');
    $products->quantity = $request->input('quantity');
    $products->productsID = $request->input('productsID');
    $products->availability = $request->input('availability');

    $image = $request->file('image');
    $imageName= $image->getClientOriginalName();
    $image->move('storage/',$imageName);
    $products->image = $request->root()."/storage/".$imageName;
    $products->save();

    return Response::json(["success" => "Product successfully updated."]);
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
