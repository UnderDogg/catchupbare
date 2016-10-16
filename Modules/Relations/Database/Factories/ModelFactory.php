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



$factory->define(Modules\Relations\Models\Relation::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company(),
        'shortname' => strtolower(trim($faker->company())),
        'relationtype_id' => $faker->numberBetween($min = 1, $max = 5)
    ];
});

$factory->define(Modules\Relations\Models\RelationAddress::class, function (Faker\Generator $faker) {
    return [
        'ismain' => '0',
        'addresstype_id' => $faker->numberBetween($min = 1, $max = 5),
        'address' => $faker->secondaryAddress(),
        'address2' => null,
        'housenumber' => $faker->randomNumber(5),
        'housenumberaddition' => null,
        'postalcode' => $faker->randomNumber(5),
        'city_id' => $faker->randomNumber(100),
        'country_id' =>  $faker->numberBetween($min = 1, $max = 100)
    ];
});



$factory->define(Modules\Relations\Models\RelationCommunication::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'vat' => $faker->randomNumber(8),
        'company_name' => $faker->company(),
        'shortname' => $faker->company(),
        'address' => $faker->secondaryAddress(),
        'city' => $faker->city(),
        'zipcode' => $faker->postcode(),
        'primary_number' => $faker->randomNumber(8),
        'secondary_number' => $faker->randomNumber(8),
        'industry_id' => $faker->numberBetween($min = 1, $max = 25),
        'fk_staff_id' => $faker->numberBetween($min = 1, $max = 3),
        'company_type' => 'ApS',
    ];
});



