<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(App\Models\Member::class, function ($faker) {
	return [
		'first' => $faker->word,
		'last' => $faker->word,
		'email' => $faker->email,
		'sms_phone' => $faker->word,
		'description' => $faker->text,
	];
});

$factory->define(App\Models\Communication::class, function ($faker) {
	return [
		'body' => $faker->text,
	];
});

$factory->define(App\Models\Message::class, function ($faker) {
	return [
		'body' => $faker->text,
	];
});

$factory->define(App\Models\Tag::class, function ($faker) {
	return [
		'tag' => $faker->word,
	];
});
