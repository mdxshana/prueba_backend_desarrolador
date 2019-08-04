<?php

namespace App\Http\Controllers;


use App\Http\Repositories\TipoDocumentoRepository;
use App\Http\Resources\TipoDocumentoResource;
use Illuminate\Http\Request;

class TipoDocumentoController extends Controller
{
    private $repository;

    public function __construct(TipoDocumentoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(){
        $tipoDocumentos = $this->repository->All();
        return response()->json(TipoDocumentoResource::collection($tipoDocumentos),200);
    }
}
