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

Route::get('/', 'HomeController@index');

Auth::routes();

//Home
Route::get('/home', 'HomeController@index');


//Quests
Route::get('/quests/add', 'QuestController@add');
Route::get('/quests/edit/{id}', 'QuestController@edit');
Route::post('/quests/post', 'QuestController@postAction');
Route::post('/quest/put/{id}', 'QuestController@putAction');
Route::get('/quests/delete/{id}', 'QuestController@deleteAction');
Route::get('/quests/restore/{id}', 'QuestController@restoreAction');

