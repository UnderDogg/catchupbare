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
$factory->define(Modules\Core\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(Modules\Core\Models\Staff::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(Modules\Relations\Models\Relation::class, function (Faker\Generator $faker) {
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

$factory->define(Modules\Relations\Models\Client::class, function (Faker\Generator $faker) {
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


$factory->define(Modules\Tickets\Models\Ticket::class, function (Faker\Generator $faker) {

    /*
    `id` int(10) UNSIGNED NOT NULL,
    `ticket_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `user_id` int(10) UNSIGNED DEFAULT NULL,
    `dept_id` int(10) UNSIGNED DEFAULT NULL,
    `team_id` int(10) UNSIGNED DEFAULT NULL,
    `priority_id` int(10) UNSIGNED DEFAULT NULL,
    `sla` int(10) UNSIGNED DEFAULT NULL,
    `help_topic_id` int(10) UNSIGNED DEFAULT NULL,
    `status` int(10) UNSIGNED DEFAULT NULL,
    `rating` tinyint(1) NOT NULL,
    `ratingreply` tinyint(1) NOT NULL,
    `hasflags` int(1) UNSIGNED NOT NULL,
    `ip_address` int(11) NOT NULL,
    `assigned_to` int(10) UNSIGNED DEFAULT NULL,
    `lock_by` int(11) NOT NULL,
    `lock_at` datetime DEFAULT NULL,
    `source` int(10) UNSIGNED DEFAULT NULL,
    `isoverdue` tinyint(1) UNSIGNED NOT NULL,
    `isreopened` tinyint(1) UNSIGNED NOT NULL,
    `isanswered` tinyint(1) UNSIGNED NOT NULL,
    `hashtml` tinyint(1) UNSIGNED NOT NULL,
    `isdeleted` tinyint(1) UNSIGNED NOT NULL,
    `isclosed` tinyint(1) UNSIGNED NOT NULL,
    `is_transferred` tinyint(1) NOT NULL,
    `transferred_at` datetime NOT NULL,
    `reopened_at` datetime DEFAULT NULL,
    `deadline` datetime DEFAULT NULL,
    `closed_at` datetime DEFAULT NULL,
    `last_message_at` datetime DEFAULT NULL,
    `last_response_at` datetime DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
    **/

    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'fk_staff_id_created' => $faker->numberBetween($min = 1, $max = 3),
        'assigned_to_staff_id' => $faker->numberBetween($min = 1, $max = 3),
        'fk_relation_id' => $faker->numberBetween($min = 1, $max = 50),
        'status_id' => $faker->numberBetween($min = 1, $max = 2),
        'deadline' => $faker->dateTimeThisYear($max = 'now'),
        'created_at' => $faker->dateTimeThisYear($max = 'now'),
        'updated_at' => $faker->dateTimeThisYear($max = 'now'),
    ];
});

$factory->define(Modules\Leads\Models\Lead::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'note' => $faker->paragraph,
        'fk_staff_id_created' => $faker->numberBetween($min = 1, $max = 3),
        'assigned_to_staff_id' => $faker->numberBetween($min = 1, $max = 3),
        'fk_relation_id' => $faker->numberBetween($min = 1, $max = 50),
        'status_id' => $faker->numberBetween($min = 1, $max = 2),
        'contact_date' => $faker->dateTimeThisYear($max = 'now'),
        'created_at' => $faker->dateTimeThisYear($max = 'now'),
        'updated_at' => $faker->dateTimeThisYear($max = 'now'),
    ];
});

