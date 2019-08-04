<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TarjetaResource extends JsonResource
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
            'numero_tarjeta' => $this->numero_tarjeta,
            'vencimiento' => $this->vencimiento,
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}
