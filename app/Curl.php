<?php
/**
 * Created by PhpStorm.
 * User: egolife
 * Date: 12.06.2015
 * Time: 23:15
 */

namespace App;


use Exception;
use Illuminate\Support\Facades\Session;

class Curl {

  protected $ch = null;
  protected $url = 'https://api.vk.com/method/ads';
  protected $defaults = [
    CURLOPT_POST            => 1,
    CURLOPT_POSTFIELDS      => null,
    CURLOPT_SSL_VERIFYPEER  => 0,
    CURLOPT_RETURNTRANSFER  => true,
  ];
  protected $defaultFields = [
    'v' => 5.34,
    'access_token' => null
  ];
  protected $options;
  protected $results;

  public function __construct($method, Array $fields = [], Array $options = []) {
    $this->url .= '.' . $method . '?';

    $this->ch = curl_init($this->url);
    if(!$this->ch)
      throw new Exception('Curl initialisation failed!');

    $this->defaultFields['access_token'] = Session::get('vk_token');
    $options[CURLOPT_POSTFIELDS] = http_build_query( array_replace($this->defaultFields, $fields) );

    $this->options = array_replace($this->defaults, $options);

    if( !curl_setopt_array($this->ch, $this->options) )
      throw new Exception('Curl options setting failed!');

    $this->results = json_decode( curl_exec($this->ch) );
    if(!$this->results)
      throw new Exception('Curl exec failed');

    curl_close($this->ch);
  }

  public function all(){
    return $this->results;
  }
}