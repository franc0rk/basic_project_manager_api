<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('login','UsersController@token');

$router->group(['middleware' => 'auth'], function() use ($router) {
    //Users routes
    $router->get('users','UsersController@index');
    $router->get('users/{id}','UsersController@show');
    $router->post('users','UsersController@store');
    $router->put('users/{id}','UsersController@update');
    $router->delete('users/{id}','UsersController@destroy');

    //Clients routes
    $router->get('clients','ClientsController@index');
    $router->get('clients/{id}','ClientsController@show');
    $router->post('clients','ClientsController@store');
    $router->put('clients/{id}','ClientsController@update');
    $router->delete('clients/{id}','ClientsController@destroy');
});