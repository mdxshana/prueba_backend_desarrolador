<?php

namespace App\Http\Repositories;

use App\Models\Persona;
use Cache;

class PersonaRepository
{
    protected $model;

    public function __construct(Persona $persona)
    {
        $this->model = $persona;
    }

    /**
     * Regresa las personas
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function All()
    {

        if (\Request::has('termino')){
            return $this->model->with('tipo_documento')->buscarCoincidencia(\Request::get('termino'))->latest()->paginate();
        }else{
            $pagina = \Request::get('page');
            return Cache::rememberForever('personas-'.$pagina, function () {
                return $this->model->with('tipo_documento')->latest()->paginate();
            });
        }
    }

    /**
     * permite alamacenar una persona en base de datos
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function store($data)
    {
        $persona = $this->model->query()->create($data);
        Cache::flush();
        return $persona;
    }

    /**
     * Obtine un unico recurso de persona
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
       return Cache::rememberForever('persona-'.$id, function () use ($id) {
           return  $this->model->query()->findOrFail($id);
        });
    }

    /**
     * Permite actualizar un recurso persona
     * @param $data
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function update($data, $id)
    {
        $persona = $this->find($id);
        $persona->fill($data);
        if ($persona->isDirty()) {
            $persona->save();
            Cache::flush();
        }
        return $persona;
    }

    /**
     * Elimina el recurso de persona
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function destroy($id)
    {
        $persona = $this->find($id);
        $persona->delete();
        Cache::flush();
        return $persona;
    }
}
