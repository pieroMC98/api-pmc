<?php

use App\Model\Category;
use App\Model\Product;
use App\Model\Transaction;
use App\Model\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		// desactivamos confirmacion de claves foraneas(temporal)
		DB::statement('set FOREIGN_KEY_CHECKS = 0');
		// borrar elementos de las tablas
		User::truncate();
		Product::truncate();
		Category::truncate();
		Transaction::truncate();
		// tabla pivote
		DB::table('category_product')->truncate();
		
		// para que no cree mensajes
		User::flushEventListeners();
		Product::flushEventListeners();
		Transaction::flushEventListeners();
		Category::flushEventListeners();

		$amount_persons = 1000;
		$amount_categories = 30;
		$amount_products = $amount_transactions = 1000;

		factory(User::class, $amount_persons)->create();
		factory(Category::class, $amount_categories)->create();

		// al momento que creamos un producto, lo asociamos con una lista de categorias
		factory(Product::class, $amount_transactions)
			->create()
			->each(function ($products) {
				// obtiene array de lista de categorias 1 al 5, identificando cada una por el id
				$categories = Category::all()
					->random(mt_rand(1, 5))
					->pluck('id');
				$products->category()->attach($categories);
			});
		factory(Transaction::class, $amount_transactions)->create();
	}
}
