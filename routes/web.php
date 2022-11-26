<?php

use App\Models\Podcast;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Route;

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

Route::get('/', static function () {
    $client = ClientBuilder::create()
        ->setHosts(['http://elasticsearch:9200'])
//        ->setBasicAuthentication('elastic', 'gBINqtPqoR4Z1ybW6eBU')
//        ->setCABundle('../http_ca.crt')
        ->build();

    $podcast = Podcast::first();

    $client->index([
        'index' => 'podcasts',
        'id' => $podcast->id,
        'body' => [
            'podcast_content' => $podcast->text_contents,
        ],
    ]);

    dd(
        $client->get([
            'id' => $podcast->id,
            'index' => 'podcasts',
        ])->asArray()
    );

    return view('welcome');
});
