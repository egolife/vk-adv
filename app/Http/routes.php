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
use App\User;

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

    /**
     * Img upload processing
     */
    Route::post('/upload-img', function(Illuminate\Http\Request $request){


      if ( $request->hasFile('uploadfile') && $request->file('uploadfile')->isValid() ) {
        $file = $request->file('uploadfile');
        $ext = "." . $file->getClientOriginalExtension();
        $filetypes = array('.jpg','.gif','.bmp','.png','.JPG','.BMP','.GIF','.PNG','.jpeg','.JPEG');
         
        if( !in_array($ext, $filetypes) ) {
          return 'формат не поддерживается';
        } else{ 
          // TODO: нужно завернуть в блок try ... catch
          $file->move(public_path() . '/img/', 'img' . $ext);
          return 'success';
        }
      } else{
        return 'error on server!';
      }
    });
    Route::get('/test', function(){
      return view('test');
    });
    Route::controller('other', 'AdsController');
    Route::resource('ad', 'AdvertController');
});

get('/roma', 'TestController@index');