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
        'phone' => $faker->phoneNumber,
        'status' => 0,
        'halal_food_only' => $faker->boolean,
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
        'delivery_time' => $faker->dateTime,
        'delivery_location' =>$faker->address,
        'total' =>$faker->randomDigit,
        'driver_id' =>$faker->randomDigit,
        'user_id' => function() {
            return auth()->id() ?: factory('App\User')->create()->id;
        }
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


$factory->define(App\Address::class, function (Faker\Generator $faker) {

    return [
        'address_line_1' => $faker->name,
        'address_line_2' => $faker->name,
        'town' => $faker->name,
        'state' => $faker->name,
        'country' => $faker->name,
        'postcode' => $faker->randomDigit,       
    ];
});

$factory->define(App\Item::class, function (Faker\Generator $faker) {
    return [
       'name' => $faker->name,
       'price' => $faker->randomFloat(2),
       'description' => $faker->sentence, 
       'order_id' => function() {
            return factory('App\Order')->create()->id;
       },
       'type' => 'food',
       'type_id' => '1'
    ];
});


