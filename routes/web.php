<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\TransactionDetail;
use Carbon\Carbon;

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

$router->group(['prefix' => 'operator'], function() use($router){
    $router->group(['prefix' => 'outlets'], function() use($router){
        $router->get('/', 'OutletController@index');
        $router->get('/paginate', 'OutletController@paginate');
        $router->post('/', 'OutletController@create');
        $router->patch('/{id}', 'OutletController@update');
        $router->delete('/{id}', 'OutletController@delete');
    });
    
    $router->group(['prefix' => 'operators'], function() use($router){
        $router->get('/', 'OperatorController@index');
        $router->get('/paginate', 'OperatorController@paginate');
        $router->post('/', 'OperatorController@create');
        $router->patch('/{id}', 'OperatorController@update');
        $router->delete('/{id}', 'OperatorController@delete');
    });
    
    $router->group(['prefix' => 'products'], function() use($router){
        $router->get('/', 'ProductController@index');
        $router->get('/paginate', 'ProductController@paginate');
        $router->get('/{id}', 'ProductController@detail');
        $router->post('/', 'ProductController@create');
        $router->patch('/{id}', 'ProductController@update');
        $router->delete('/{id}', 'ProductController@delete');
    });
    
    $router->group(['prefix' => 'transactions'], function() use($router){
        $router->post('/', 'TransactionController@create');
    });
});

$router->group(["prefix" => "admin"], function() use($router){
    $router->group(["prefix" => "transactions"], function() use($router){
        $router->get('/', 'TransactionController@index');
        $router->get('/{id}', 'TransactionController@detail');
        $router->patch('/{id}', 'TransactionController@update');
        // $router->delete('/{id}', 'TransactionController@delete');
        // $router->delete('/{transaction_id}/{id}', 'TransactionController@deleteTransactionDetail');
    });

    $router->group(["prefix" => "products"], function() use($router){
        $router->get('/', 'ProductController@index');
    });
});

$router->group(['prefix' => "category"], function() use($router){
    $router->get('/', 'CategoryController@index');
    $router->get('/paginate', 'CategoryController@paginate');
});

$router->group(['prefix' => "unit"], function() use($router){
    $router->get('/', 'UnitController@index');
    $router->get('/paginate', 'UnitController@paginate');
});

$router->get('/test', function(){
    $product_id = 32;
    return TransactionDetail::with(['transaction' => function($q){
        $q->where('date', Carbon::today()->subDays(30));
    }])->where('product_id', $product_id)->sum('price');
});