<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Product;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'=>$faker->word,
        'brief'=> $faker->paragraph(1),
        'quantify'=> $faker->numberBetween(1,10),
        'status'=> $faker->randomElement([Product::AVAILABLE, Product::UNAVAILABLE]),
        'image'=> $faker->randomElement(['1.jpg', '2.jpg', '3.jpeg']),
        'seller_id' => User::inRandomOrder()->first()->id,
        //'seller_id' => User::all()->random()->id
    ];
});
