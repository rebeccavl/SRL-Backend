<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Illuminate\Http\Request;
use JWTAuth;
use Auth;

class CatController extends Controller
{
  public function __construct()
  {
    $this->middleware('jwt.auth', ['only'=>['store','update','destroy']]);
  }

  public function index()
  {
    $category = Category::all();
  }

  public function store(Request $request)
  {
    $rules =[
      'category' => 'required',
      'description' => 'required'
      'image' => 'required'
    ];

    $validator = Validator::make(Purifier::clean($request->all()),$rules);

    if($validator->fails())
    {
      return Response::json(["error" => "Please fill out all fields."]);
    }

    $user = Auth::user();
    if($user->roleID != 1)
    {
      return Response::json(["error" => "You can't enter here."]);
    }

    $category = new Category;

    $category->category = $request->input('category');
    $category->description = $request->input('description');

    $image = $request->file('image');
    $imageName= $image->getClientOriginalName();
    $image->move('storage/',$imageName);
    $category->image = $request->root()."/storage/".$imageName;
    $category->save();

    return Response::json(["success" => "Your category has been added."]);
  }



  public function update($id, Request $request)
  {
    $category = Category::find($id);

    $category->category = $request->input('category');
    $category->description = $request->input('description');

    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $image->move("storage/",$imageName);
    $category->image = $request->root(). "/storage/".$imageName;

    $category->save();

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
    {
      return Response::json(["error"=>"please fill out all fields"]);
    }
    
    return Response::json(["success"=>"Category Updated."]);
  }



  public function show($id)
  {
    $category = Category::find($id);

    return Response::json($category);
  }



  public function destroy($id)
  {
    $category = Category::find($id);

    $category->delete();

    return Response::json(['success' => 'Category Deleted.']);
  }
}
