<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Transaction\TransactionCategoryController;
use Transaction\TransactionSellerController;

use Buyer\BuyerTransactionController;
use Buyer\BuyerProductController;
use Buyer\BuyerSellerController;
use Buyer\BuyerCategoryController;

use Category\CategorySellerController;
use Category\CategoryTransactionController;
use Category\CategoryBuyerController;
use Category\CategoryProductController;

use Seller\SellerTransactionController;
use Seller\SellerCategoryController;
use Seller\SellerBuyerController;
use Seller\SellerProductController;

use Product\ProductTransactionController;
use Product\ProductBuyerController;
use Product\ProductCategoryController;
use Product\ProductBuyerTransactionController;

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
Route::get('hail/{x?}', function (Request $x) {
	$x = $x->input('x');
	if (isset($x)) {
		echo '<h3>Hello World!</h3>';
	} else {
		echo '<h3>Hello World! to ' . $x . '</h3>';
	}
});

Route::resource('/user', 'User\UserController', [
	'except' => ['create', 'edit'],
]);

Route::resource('buyer', 'Buyer\BuyerController', [
	'only' => ['show', 'index'],
]);

Route::resource('category', 'Category\CategoryController', [
	'except' => ['create', 'edit'],
]);

Route::resource('product', 'Product\ProductController', [
	'only' => ['show', 'index'],
]);

Route::resource('transaction', 'Transaction\TransactionController', [
	'only' => ['show', 'index'],
]);

/* Route::resource('transaction.categories', 'Transaction\TransactionCategoryController', [ */
/* 'only' => ['index'], */
/* ]); */
Route::resource(
	'transaction.categories',
	TransactionCategoryController::class
)->only(['only' => 'index']);

Route::resource('seller', 'Seller\SellerController', [
	'only' => ['show', 'index'],
]);

Route::resource(
	'transaction.sellers',
	TransactionSellerController::class
)->only(['only' => 'index']);

Route::resource('buyer.transactions', BuyerTransactionController::class)->only(
	'index'
);
Route::resource('buyer.products', BuyerProductController::class)->only('index');
Route::resource('buyer.sellers', BuyerSellerController::class)->only('index');
Route::resource('buyer.categories', BuyerCategoryController::class)->only(
	'index'
);

Route::resource('category.products', CategoryProductController::class)->only(
	'index'
);
Route::resource('category.sellers', CategorySellerController::class)->only(
	'index'
);
Route::resource(
	'category.transactions',
	CategoryTransactionController::class
)->only('index');

Route::resource('category.buyers', CategoryBuyerController::class)->only(
	'index'
);

Route::resource(
	'seller.transactions',
	SellerTransactionController::class
)->only('index');

Route::resource('seller.categories', SellerCategoryController::class)->only(
	'index'
);

Route::resource('seller.buyers', SellerBuyerController::class)->only('index');

Route::resource('seller.products', SellerProductController::class)->except([
	'create',
	'show',
	'edit',
]);

Route::resource(
	'product.transactions',
	ProductTransactionController::class
)->only('index');

Route::resource('product.buyers', ProductBuyerController::class)->only('index');

Route::resource('product.categories', ProductCategoryController::class)->only([
	'index',
	'destroy',
	'update',
]);
Route::resource('product.buyers.transactions', ProductBuyerTransactionController::class)->only('store');
