<?php

//PAGINA INICIAL
Route::get('/', function () {
    return view('welcome');
});

//GRUPO DE RUTAS DE LOGIN
Route::group(['prefix' => 'login', 'middleware' => 'cors'], function() {
    Route::post('log', 'LogController@log');
    Route::get('logout', 'LogController@logout');    
});

//GRUPO DE RUTAS DE USUARIO
Route::group(['prefix' => 'users', 'middleware' => 'cors'], function() {
    Route::get('all', 'UserController@all');
    Route::get('paginate/{desde}', 'UserController@paginate');
    Route::get('getUser/{id}', 'UserController@getUser');
    Route::put('update/{id}', 'UserController@update');
    Route::delete('delete/{id}', 'UserController@delete');
    Route::post('create', 'UserController@create');        
});

//GRUPO DE RUTAS DE PRODUCTOS
Route::group(['prefix' => 'productos', 'middleware' => 'cors'], function() {
    Route::get('all', 'ProductoController@all');
    Route::get('paginate/{desde}', 'ProductoController@paginate');
    Route::get('getProducto/{id}', 'ProductoController@getProducto');
    Route::put('update/{id}', 'ProductoController@update');
    Route::delete('delete/{id}', 'ProductoController@delete');
    Route::post('create', 'ProductoController@create');     
});


//GRUPO DE RUTAS DE EMPRESAS
Route::group(['prefix' => 'empresas', 'middleware' => 'cors'], function() {
    Route::get('all', 'EmpresaController@all');
    Route::get('paginate/{desde}', 'EmpresaController@paginate');
    Route::get('getEmpresa/{id}', 'EmpresaController@getEmpresa');
    Route::put('update/{id}', 'EmpresaController@update');
    Route::delete('delete/{id}', 'EmpresaController@delete');
    Route::post('create', 'EmpresaController@create');     
});


//GRUPO DE RUTAS DE CATEGORIAS
Route::group(['prefix' => 'categorias', 'middleware' => 'cors'], function() {
    Route::get('all', 'CategoriaController@all');
    Route::get('paginate/{desde}', 'CategoriaController@paginate');
    Route::get('getCategoria/{id}', 'CategoriaController@getCategoria');
    Route::put('update/{id}', 'CategoriaController@update');
    Route::delete('delete/{id}', 'CategoriaController@delete');
    Route::post('create', 'CategoriaController@create');     
});


//GRUPO DE RUTAS DE COMPRAS
Route::group(['prefix' => 'compras', 'middleware' => 'cors'], function() {
    Route::get('all', 'CompraController@all');
    Route::get('paginate/{desde}', 'CompraController@paginate');
    Route::get('getCompra/{id}', 'CompraController@getCompra');
    Route::put('update/{id}', 'CompraController@update');
    Route::delete('delete/{id}', 'CompraController@delete');
    Route::post('create', 'CompraController@create');     
});

