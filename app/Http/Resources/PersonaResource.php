<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'tipo_documento' => TipoDocumentoResource::make($this->tipo_documento),
            'n_documento' => $this->n_documento,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion
        ];
    }
}
