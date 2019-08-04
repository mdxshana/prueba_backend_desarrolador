<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarjetaCredito extends Model
{
    protected $fillable = [
        'numero_tarjeta',
        'vencimiento',
        'cvc'
    ];

    /**
     * modifica el valor del numero de tarjeta para regresarlo a la vista
     * @param $value
     * @return string
     */
    public function getNumeroTarjetaAttribute($value)
    {
        $ultimos_cuatro = substr($value,strlen($value)-4,strlen($value));
        return "xxxx-".$ultimos_cuatro;
    }
}
