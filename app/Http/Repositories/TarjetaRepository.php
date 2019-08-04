<?php


namespace App\Http\Repositories;


use App\Models\TarjetaCredito;

class TarjetaRepository
{
    protected $model;

    public function __construct(TarjetaCredito $persona)
    {
        $this->model = $persona;
    }

    /**
     * obtener todas las terjetas de una persona
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($id){
        return $this->model->query()->where('persona_id',$id)->get();
    }

    /**
     * crear una nueva tarjeta a una persona
     * @param $data
     * @param $id
     * @return TarjetaCredito
     */
    public function store($data, $id){
        $this->model->fill($data);
        $this->model->persona_id = $id;
        $this->model->save();
        return $this->model;
    }

    /**
     * Permite obtener informacion de una taarjeta
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function find($id){
        return $this->model->query()->findOrFail($id);
    }

    /**
     * Eliminar una tarjeta
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function destroy($id){
        $tajeta = $this->find($id);
        $tajeta->delete();
        return $tajeta;
    }
}
