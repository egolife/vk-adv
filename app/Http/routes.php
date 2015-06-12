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

Route::get('/authorize', ['as' => 'authorize', 'uses' => 'VkController@authorize']);

Route::group(['middleware' => 'vk.auth'], function(){

  Route::get('/', 'VkController@index');
});



Route::get('/home', function(\Illuminate\Http\Request $request) {
  if($request->exists('code')){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://oauth.vk.com/access_token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
          http_build_query([
            'client_id' => '4955326',
            'client_secret' => 'fIejfSmEJhbUL6jDuBzM',
            'code' => $request->get('code'),
            'redirect_uri' => 'http://vk-adv.dev/home'
          ]));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $vkResponse = json_decode( curl_exec ($ch));
    curl_close ($ch);

    Session::put('vk_expires', $vkResponse->expires_in );
    Session::put('vk_token', $vkResponse->access_token );
    Session::put('vk_userid', $vkResponse->user_id );

  } else{
    dd('ELSE CASE');
    return 'запросили страницу home напрямую, вместо редиректа из ВК';

  }
  return redirect('/');
});

Route::get('/compaigns/{account}', ['as' => 'compaigns', 'uses' => function($acc){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,"https://api.vk.com/method/ads.getCampaigns");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query([
      'v' => 5.34,
      'access_token' => Session::get('vk_token'),
      'account_id' => $acc
    ]));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $res = json_decode( curl_exec ($ch));
  curl_close ($ch);
  return $res->response;
}]);