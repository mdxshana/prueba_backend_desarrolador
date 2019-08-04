<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PersonaRepository;
use App\Http\Requests\PersonaRequest;

use App\Http\Resources\PersonaColletion;
use App\Http\Resources\PersonaResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PersonaController extends Controller
{

    private $repository;

    public function __construct(PersonaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Permite listar todas las personas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personas = $this->repository->All();
        return  response()->json(new PersonaColletion($personas));
    }



    /**
     * Permite almacenar una persona en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonaRequest $request)
    {
        try{
            $persona = $this->repository->store($request->all());
            return response()->json(PersonaResource::make($persona),201);
        }catch (\Exception $exception){
            \Log::debug('Error almacenando la persona ' . $exception->getMessage());
            return response()->json('Tenemos dificultades intente mas tarde',500);
        }
    }

    /**
     * Regresa el registro de una persona en concreto.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $persona = $this->repository->find($id);
            return response()->json(PersonaResource::make($persona),200);
        }catch (ModelNotFoundException $exception){
            \Log::debug('Error al obtener la persona ' . $exception->getMessage());
            return response()->json('El recurso que busca no se encuentra disponible',404);
        }
    }



    /**
     * Permite actualizar el registro de una persona.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PersonaRequest $request, $id)
    {
        try{
            $persona = $this->repository->update($request->all(),$id);
            return response()->json(PersonaResource::make($persona),200);
        }catch (ModelNotFoundException $exception){
            \Log::debug('Error al obtener la persona ' . $exception->getMessage());
            return response()->json('El recurso que busca no se encuentra disponible',404);
        }catch (\Exception $exception){
            \Log::debug('No fue posible actualizar la persona ' . $exception->getMessage());
            return response()->json('Tenemos dificultades intente mas tarde',500);
        }
    }

    /**
     * Elimina el registro de una persona de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $persona = $this->repository->destroy($id);
            return response()->json(PersonaResource::make($persona),200);
        }catch (ModelNotFoundException $exception){
            \Log::debug('Error al obtener la persona ' . $exception->getMessage());
            return response()->json('El recurso que busca no se encuentra disponible',404);
        }catch (\Exception $exception){
            \Log::debug('No fue posible eliminar a la persona ' . $exception->getMessage());
            return response()->json('Tenemos dificultades intente mas tarde',500);
        }
    }
}
