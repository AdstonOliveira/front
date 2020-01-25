<?php

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('cliente')->group(function(){
    Route::get('/novo', "ClienteController@novo")->name('cliente.novo');
    Route::get('/{id}', 'ClienteController@show');
    Route::post('/save', 'ClienteController@save')->name('cliente.salvar');

    Route::get('/', 'ClienteController@index')->name('cliente.index');
});

Route::prefix('produto')->group(function(){
    Route::get('/novo',"ProdutoController@create")->name('produto.novo');
    Route::get('/{id}', 'ProdutoController@show')->name('produto.editar');
    Route::post('/store', 'ProdutoController@store')->name('produto.salvar');

    Route::get('/', "ProdutoController@index")->name('produto.index');
});
