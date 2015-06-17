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

// TODO: Проводит серверную авторизацию ВК, вызывается через редирект
Route::get('/authorize', ['as' => 'authorize', 'uses' => 'VkController@authorize']);

/**
 * TODO: Сейчас показывает список кобинетов, в дальнейшем не требуется
 */
Route::get('/home', ['as' => 'home', 'uses' => 'VkController@tokenize']);

Route::group(['middleware' => 'vk.auth'], function () {

    Route::get('/', ['as' => 'vk.acc.set', 'uses' => 'VkController@index']);
    Route::get('/compaigns/{account}', ['as' => 'compaigns', 'uses' => 'VkController@getCompaigns']);
    Route::get('/set_acc/{acc}', ['as' => 'vk.acc.put', 'uses' => 'VkController@setAcc']);
    Route::get('/ads/{account}/{compaign}', ['as' => 'ads', 'uses' => 'VkController@getAds']);
    Route::get('/ads/{account}', ['as' => 'all_ads', 'uses' => 'VkController@getAllAds']);
//    Route::get('/')
    Route::controller('other', 'AdsController');
    Route::resource('ad', 'AdvertController');
});