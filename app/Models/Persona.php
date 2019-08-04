<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'nombres',
        'apellidos',
        'n_documento',
        'tipo_documento_id',
        'direccion',
        'telefono',
        'email'
    ];


    public function scopeBuscarCoincidencia($query, $termino){
        return $query->whereLike($this->fillable, $termino);
    }


    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class);
    }
}
