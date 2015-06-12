<?php

namespace App\Http\Controllers;

use App\Curl;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VkController extends Controller
{

  const AUTH_URL = 'https://oauth.vk.com/authorize?';

  public function authorize(){
    $params = http_build_query([
      'client_id' => env('VK_APP_ID'),
      'redirect_url' => env('VK_APP_REDIRECT'),
      'display' => 'popup',
      'scopte' => 'ads'
    ]);

    return redirect( self::AUTH_URL . $params );
  }

  public function index(){
    $curl = new Curl( 'getAccounts' );
    return view('vk.accounts')->with('res', $curl->all()->response);
  }
}
