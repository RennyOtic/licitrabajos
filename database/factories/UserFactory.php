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

$factory->define(App\Usuario::class, function (Faker $faker) {
	$emails = [
		'@sahum.gob.ve',
		'@gmail.com',
		'@hotmail.com',
		'@outlook.com',
		'@yahoo.com',
		'@mail.com'
	];
	$name = $faker->firstName;
	$user = $faker->bothify($name.'#?##?');
	return [
		'nombre' => $name,
		'apellido' => $faker->lastName,
		'identificacion' => rand(500000, 50000000),
		'correo' => $user . $emails[rand(0, 5)],
		'password' => bcrypt('secret'),
	];
});

$factory->define(App\Models\Permisologia\Rol::class, function (Faker $faker) {
	$rol = $faker->numerify('Rol ####');
	return [
		'nombre' => $rol,
		'slug' => $rol,
		'descripcion' => 'Rol de prueba',
		'desde_at' => \Carbon\Carbon::parse('08:00:00'),
		'hasta_at' => \Carbon\Carbon::parse('17:00:00'),
		'especial' => null
	];
});