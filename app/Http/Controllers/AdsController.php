<?php

namespace App\Http\Controllers;

use App\Curl;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdsController extends Controller
{
    public function getStats($acc = 1602483811)
    {
        $curl = new Curl('ads.getFloodStats', ['account_id' => $acc]);
        dd($curl->all()->response);
    }
}
