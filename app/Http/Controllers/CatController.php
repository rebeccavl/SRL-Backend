<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Illuminate\Http\Request;

class CatController extends Controller
{
  public function store(Request $request)
  {
    $rules =[
      'categoryName' => 'required',
      'image' => 'required'
    ];

    $validator = Validator::make(Purifier::clean($request->all()),$rules);

    if($validator->fails())
    {
      return Response::json(["error" => "Please fill out all fields."]);
    }
    user = Auth::user();
    if($user->roleID != 1)
    {
      return Response::json(["error" => "You can't enter here."]);
    }

    $category = new category;

    $category->categoryName = $request->input('categoryName');

    $image = $request->file('image');
    $imageName= $image->getClientOriginalName();
    $image->move('storage/',$imageName);
    $category->image = $request->root()."/storage/".$imageName;
    $category->save();

    return Response::json(["success" => "Your category has been added."]);
  }

}
