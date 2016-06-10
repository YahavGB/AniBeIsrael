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
$app->get('/image-filter/render', 'ImageFilteringController@renderFilteredImage');
$app->get('/image-filter/create', 'ImageFilteringController@createFilteredImage');
$app->get('/image-filter/download', 'ImageFilteringController@downloadFilteredImage');

$app->get('/test', function() use ($app) {

    $flagPath = storage_path('app/image-resources/israel-flag.png');
    
    app(\App\Services\Drawing\ImageFilterService::class)->renderFilteredImage(
        'https://graph.facebook.com/10208472712528961/picture?width=9999',
        $flagPath);
});

/*
$app->get('/', function () use ($app) {
    return $app->version();
});
*/