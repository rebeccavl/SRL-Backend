<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Hash;
use JWTAuth;
use App\User;
use Response;
use File;
use Auth;

class OrdersController extends Controller
{
  public function index()
  {
    $order = Order::all();
    return Response::json($order);
  }


  public function store(Request $request)
  {
    $rules=[
      "productID" => "required",
      "quantity" => "required",
    ];
    $validator = Validator::make(Purifier::clean($request->all()),$rules);
    if($validator->fails())
    {
      return Response::json(["error"=>"please fill out all fields"]);
    }

    $order = new Order;
    $order->userID = Auth::user()->id;
    $order->productID = $request->input("productID");
    $order->quantity = $request->input("quantity");
    $order->comments = $request->input("comments");
    $order->totalPrice = $request->input("totalPrice");
    $order->save();

    return Response::json(["success"=>"You're order is complete."]);
  }


  public function show($id)
  {
    $order = Order::find($id);
    return Response::json($Order);
  }



  public function destroy($id)
  {
    $order = Order::find($id);
    $order->delete();
  }
}
