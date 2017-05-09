<?php

use Illuminate\Http\Request;





Route::post('storeProduct','ProductsController@store');
Route::post('updateProduct/{id}','ProductsController@update');
Route::get('showProduct/{id}','ProductsController@show');
Route::post('deleteProduct/{id}','ProductsController@destroy');

Route::post('storeOrder','OrdersController@store');
Route::get('showOrder/{id}','OrdersController@show');
Route::post('deleteOrder/{id}','OrdersController@destroy');

Route::get('getRoles', 'RolesController@index');
Route::post('storeRole','RolesController@store');
Route::post('updateRole/{id}','RolesController@update');
Route::get('showRole/{id}','RolesController@show');
Route::post('deleteRole/{id}','RolesController@destroy');

Route::get('getCategory', 'CatController@index');
Route::post('storeCategory','CatController@store');
Route::post('updateCategory/{id}','CatController@update');
Route::get('showCategory/{id}','CatController@show');
Route::post('deleteCategory/{id}','CatController@destroy');

Route::get('getUsers', 'CatController@index');
Route::post('SignIn', 'UserController@SignIn');
Route::post('SignUp','UsersController@SignUp');

Route::any('{path?}', 'MainController@index')->where("path", ".+");
