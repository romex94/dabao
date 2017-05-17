<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),

        //chef side
        'religion' => $faker->name,
        'address' => $faker->streetAddress,
        'phone' => $faker->phoneNumber,
        'preorderStatus' => 0,
        'status' => 0,
        //'image' => $faker->imageUrl($width = 640, $height = 480),
        //'fname' => $faker->firstName,
    ];
});


$factory->define(App\Complain::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->text,
        'title' => $faker->name,
        'user_id' => function() {
            return factory('App\User')->create()->id;
        }
    ];
});

$factory->define(App\Order::class, function (Faker\Generator $faker) {

    return [
        'food' => $faker->name,
        'quantity' => $faker->randomDigit,
        'date' => $faker->date,

       //'password' => $password ?: $password = bcrypt('secret'),
       // 'remember_token' => str_random(10),
        
    ];
});

$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'order_id' => function() {
            return factory('App\Order')->create()->id;
        },
        'amount' => $faker->randomFloat(2, 30, 200),
        'type' => $faker->randomElement(['in', 'out', 'refund'])
    ];
});


