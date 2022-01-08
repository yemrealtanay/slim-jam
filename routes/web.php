<?php

use Illuminate\Support\Facades\Route;
use Shopify\Clients\Rest;
use Google\Cloud\Translate\V2\TranslateClient;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('shopifytest', function (Rest $client) {
    //  Show results of shopify api's /products uri
    $response = $client->get('products');
    return $response->getDecodedBody();
});

Route::get('translatetest', function () {
    $translationConfig = [
        'keyFilePath' => storage_path('app/' . config('services.google_cloud.key_file')),
        'suppressKeyFileNotice' => true,
    ];

    if (config('services.google_cloud.translation_default_target')) {
        $translationConfig['target'] = config('services.google_cloud.translation_default_target');
    }

    $translate = new TranslateClient($translationConfig);

    $result = $translate->translate(
        'Hello world!'
    );

    return $result['text'];
});
