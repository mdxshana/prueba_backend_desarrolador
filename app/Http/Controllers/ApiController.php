<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::query()->latest()->get();

        return response()->json($usuarios,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $usuario = new User($request->all());
        $usuario->password = bcrypt('secret');
        $usuario->save();
        return response()->json($usuario,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::query()->findOrFail($id);
        return response()->json($usuario,200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $usuario = User::query()->findOrFail($id);
        $usuario->fill($request->all());
        if($usuario->isDirty()){
            $usuario->save();
        }
        return response()->json($usuario,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = User::query()->findOrFail($id);
        $usuario->delete();
        return response()->json($usuario,200);
    }
}
