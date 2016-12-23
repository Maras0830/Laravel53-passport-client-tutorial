<?php

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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '5',
        'redirect_uri' => 'http://Laravel53-passport-client.dev/callback',
        'response_type' => 'code',
        'scope' => 'Facebook_information GitHub_information', //加上 scopes
    ]);

    return redirect('http://Laravel53-passport-server.dev/oauth/authorize?'.$query);
});

Route::get('/callback', function (Request $request) {
    $client = new GuzzleHttp\Client;

    $response = $client->post('http://Laravel53-passport-server.dev/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '5',
            'client_secret' => 'esRSCGGNtJHhPt2huGM4grC24WDcmU82C3SwKGUE',
            'redirect_uri' => 'http://Laravel53-passport-client.dev/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
