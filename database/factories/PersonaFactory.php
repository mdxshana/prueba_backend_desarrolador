<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Persona;
use Faker\Generator as Faker;

$factory->define(Persona::class, function (Faker $faker) {
    return [
        'nombres' => $faker->firstName,
        'apellidos' => $faker->lastName,
        'n_documento' => $faker->unique()->randomNumber(8),
        'tipo_documento_id' => 1,
        'email' => $faker->email,
        'direccion' => $faker->address,
        'telefono' => $faker->randomNumber(8)
    ];
});
