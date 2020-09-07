<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Buyer;
use App\Seller;
use App\Transaction;
use App\User;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    $seller = Seller::has('product')->get()->random();
    $buyer = User::all()->except($seller->id)->random();
    return [
        'name'=> $faker->word,
        'quantify'=> $faker->numberBetween(1,3),
        'buyer_id'=> $buyer->id,
        'product_id'=>$seller->product->random()->id,
    ];
});
