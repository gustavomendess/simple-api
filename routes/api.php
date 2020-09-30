<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function (){
    Route::post('registry', 'AutenticadorController@registry');
    Route::post('login', 'AutenticadorController@login');
    Route::get('registro/ativar/{id}/{token}', 'AutenticadorController@ativarRegistro');
    Route::middleware('auth:api')->group(function (){
        Route::post('logout', 'AutenticadorController@logout');
    });
});

Route::get('produtos', 'ProductController@index')->middleware('auth:api');
