<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\TarjetaCredito::class, function (Faker $faker) {
    return [
        'numero_tarjeta' => $faker->creditCardNumber,
        'vencimiento' => $faker->creditCardExpirationDateString,
        'cvc' => 623,
        'persona_id' => factory(\App\Models\Persona::class)->create()
    ];
});
