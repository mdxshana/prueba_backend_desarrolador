<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('personas','PersonaController');
    Route::get('tipo-documentos','TipoDocumentoController@index');
    Route::get('tarjetas/{id}','TarjetaController@index');
    Route::post('tarjetas/{id}','TarjetaController@store');
    Route::delete('tarjetas/{id}','TarjetaController@destroy');
    Route::post('logout','ApiAuthController@logout');
});

Route::post('login','ApiAuthController@login');


