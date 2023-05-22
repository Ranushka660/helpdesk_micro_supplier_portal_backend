<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' =>'api/portal'], function () use ($router) {
    //
    $router->get('/requisition/{slug}', ['uses' => 'RequestController@load_request_data']);
    $router->post('/quotation/{quotation_request}', ['uses' => 'RequestController@upload']);

});
