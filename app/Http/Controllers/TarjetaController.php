<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TarjetaRepository;
use App\Http\Requests\TarjetaRequest;
use App\Http\Resources\TarjetaResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TarjetaController extends Controller
{
    private $repository;

    public function __construct(TarjetaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * metetodo obtener tarjetas de una persona
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($id){
        $tarjetas = $this->repository->all($id);
        return TarjetaResource::collection($tarjetas);
    }

    /**
     * permite crear una tarjeta a una persona
     * @param TarjetaRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TarjetaRequest $request, $id){
        try{
            $data = $request->all();
            $data['vencimiento'] = str_replace(' ','',$data['vencimiento']);
            $data['numero_tarjeta'] = str_replace(' ','',$data['numero_tarjeta']);
            $tarjeta = $this->repository->store($data, $id);
            return response()->json(TarjetaResource::make($tarjeta),201);
        }catch (ModelNotFoundException $exception){
            \Log::debug('Error al obtener la persona ' . $exception->getMessage());
            return response()->json('El recurso que busca no se encuentra disponible',404);
        }catch (\Exception $exception){
            \Log::debug('Error almacenando la tarjeta ' . $exception->getMessage());
            return response()->json('Tenemos dificultades intente mas tarde',500);
        }

    }

    /**
     * eliminar tarjeta de una persona
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        try{
            $tarjeta = $this->repository->destroy($id);
            return response()->json(TarjetaResource::make($tarjeta));
        }catch (ModelNotFoundException $exception){
            \Log::debug('Error al obtener la tarjeta ' . $exception->getMessage());
            return response()->json('El recurso que busca no se encuentra disponible',404);
        }catch (\Exception $exception){
            \Log::debug('Error eliminado la tarjeta ' . $exception->getMessage());
            return response()->json('Tenemos dificultades intente mas tarde',500);
        }
    }
}
