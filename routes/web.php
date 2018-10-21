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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/normal/summoner/{id}', function($id){
    return \App\Http\Resources\Summoner::collection(\App\Summoner::where('account_id', $id)->get());
});
Route::get('/ranked/summoner/{id}', function($id){
    return \App\Http\Resources\SummonerRanked::collection(\App\SummonerRanked::where('account_id', $id)->get());
});
Route::get('/normal/opponent/{id}', function($id){
    return \App\Http\Resources\Opponent::collection(\App\Opponent::where('account_id', $id)->get());
});
Route::get('/ranked/opponent/{id}', function($id){
    return \App\Http\Resources\OpponentRanked::collection(\App\OpponentRanked::where('account_id', $id)->get());
});

Route::get('/splash/{account_id}', function($account_id){
   $champ =  \App\Summoner::where('account_id', $account_id)->orderBy('num_games', 'desc')->first();
   return \App\Champion::where('champion_name', $champ->championName)->first()->splash_url;
});