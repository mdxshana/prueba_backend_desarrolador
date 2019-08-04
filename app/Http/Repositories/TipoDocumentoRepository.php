<?php


namespace App\Http\Repositories;


use App\Models\TipoDocumento;

class TipoDocumentoRepository
{
    protected $model;

    public function __construct(TipoDocumento $tipoDocumento)
    {
        $this->model = $tipoDocumento;
    }


    public function All(){
        return $this->model->all();
    }

}
