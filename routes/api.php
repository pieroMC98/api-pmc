<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */
Route::resource('/user','User\UserController',['except'=>['create', 'edit']]);
Route::resource('buyer','Buyer\BuyerController',['only'=>['show','index']]);
Route::resource('category','Category\CategoryController',['except'=>['create','edit']]);
Route::resource('product','Product\ProductController',['only'=>['show','index']]);
Route::resource('transaction','Transaction\TransactionController',['only'=>['show','index']]);
Route::resource('seller','Seller\SellerController',['only'=>['show','index']]);
