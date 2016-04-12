<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('telegram', 'TelegramController');

Route::get('{token}/index', array('as' => 'index', 'uses' => 'TelegramController@index'));
Route::post('{token}/index', array('as' => 'index', 'uses' => 'TelegramController@index'));

Route::get('{token}/manual', array('as' => 'manual', 'uses' => 'TelegramController@manual'));

Route::get('{token}/create', array('as' => 'create', 'uses' => 'TelegramController@create'));
Route::get('{token}/destroy', array('as' => 'delete', 'uses' => 'TelegramController@destroy'));
