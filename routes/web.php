<?php

use App\Http\Controllers\PodcastController;
use App\Models\Podcast;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

//Route::get('/', static function () {
//    $client = ClientBuilder::create()
//        ->setHosts(['http://elasticsearch:9200'])
//        ->setBasicAuthentication('elastic', 'gBINqtPqoR4Z1ybW6eBU')
//        ->setCABundle('../http_ca.crt')
//        ->build();

//    $podcast = Podcast::first();

//    $client->index([
//        'index' => 'podcasts',
//        'id' => $podcast->id,
//        'body' => [
//            'podcast_content' => $podcast->text_contents,
//        ],
//    ]);
//
//    dd(
//        $client->get([
//            'id' => $podcast->id,
//            'index' => 'podcasts',
//        ])->asArray()
//    );

//    return view('welcome');
//});

//Route::post('/upload', static function() {
//    $path = Storage::putFile('podcasts/', request()->file('file'));
//    dd($path);
//});

//Route::get('/upload', static function () {
//    $apiToken = config('assembly_ai.api_token');
//    $curl = curl_init();
//    curl_setopt_array($curl, [
//        CURLOPT_URL => config('assembly_ai.upload_endpoint'),
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_CUSTOMREQUEST => 'POST',
//        CURLOPT_POSTFIELDS => file_get_contents('../storage/app/podcasts/bvKcUylEaWGQN1qaw0TDxIq1ofhIz0R0tbbvPeFl.mp3'),
//        CURLOPT_HTTPHEADER => [
//            "authorization: $apiToken",
//        ],
//    ]);
//    $response = curl_exec($curl);
//    $err = curl_error($curl);
//    curl_close($curl);
//    if ($err) {
//        echo 'cURL Error #:' . $err;
//    } else {
//        echo $response;
//    }

//    $uploadUrl = json_decode($response)->upload_url;

//    $curl = curl_init();
//    curl_setopt_array($curl, [
//        CURLOPT_URL => 'https://api.assemblyai.com/v2/transcript',
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_CUSTOMREQUEST => 'POST',
//        CURLOPT_POSTFIELDS => json_encode(['audio_url' => $uploadUrl]),
//        CURLOPT_HTTPHEADER => [
//            "authorization: $apiToken",
//            'content-type: application/json',
//        ],
//    ]);
//    $response = curl_exec($curl);
//    $err = curl_error($curl);
//    curl_close($curl);
//    if ($err) {
//        echo 'cURL Error #:' . $err;
//    } else {
//        echo $response;
//    }
//});
