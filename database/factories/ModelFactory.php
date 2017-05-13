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

$factory->define(App\Order::class, function (Faker\Generator $faker) {

    return [
        'food' => $faker->name,
        'quantity' => $faker->randomDigit,
        'date' => $faker->date,

       //'password' => $password ?: $password = bcrypt('secret'),
       // 'remember_token' => str_random(10),
        
    ];
});

