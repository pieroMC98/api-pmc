<?php

use App\Http\Resources\UserResource;
use App\Model\User;
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
use Illuminate\Database\Eloquent\Model;
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
])->middleware('input');

Route::name('userr')->get('userr/{user}/sort_by/{attribute}', function (
	$user,
	$attribute
) {
	return (new UserResource(User::find($user)))->additional([
		'meta' => ['atr' => $attribute],
	]);
});

Route::get('/{class}/{id}/sort_by/{atr}', function ($class) {
	$c = "\App\Model\\".ucfirst($class);
	$c = call_user_func($c."::class");
	dd($c);
	dd(new $c);
})->where(['class' => '[a-z]+', 'id' => '[1-9]+', 'atr' => '[a-z]+']);

Route::name('verify')->get('user/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get('user/{user}/resend', [User::class,'resend']);

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
Route::resource(
	'product.buyers.transactions',
	ProductBuyerTransactionController::class
)->only('store');
