<?php

use Illuminate\Http\Response;
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

$app->get('/', 'HomeController@index');
$app->get('/authorization/resolve', 'AuthorizationController@resolve');
$app->get('/image-filter/render', 'HomeController@renderFilteredImage');
$app->get('/image-filter/create', 'HomeController@createFilteredImage');

/*
$app->get('/', function () use ($app) {
    return $app->version();
});
*/