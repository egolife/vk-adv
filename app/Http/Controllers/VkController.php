<?php

namespace App\Http\Controllers;

use App\Curl;
use App\VkAds;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class VkController extends Controller
{

    const AUTH_URL = 'https://oauth.vk.com/authorize?';
    protected $left, $refresh, $cc;

    public function __construct(VkAds $vkAds)
    {
        if (!Session::has('acc')) {
//      $accs = $vkAds->getAccounts();

            return redirect('/');
        } else {
            $this->acc = Session::get('acc');
        }
    }

    public function authorize()
    {
        $params = http_build_query([
          'client_id'    => env('VK_APP_ID'),
          'redirect_uri' => env('VK_APP_REDIRECT'),
          'display'      => 'popup',
          'scope'        => 'ads'
        ]);

        return redirect(self::AUTH_URL . $params);
    }

    public function tokenize(\Illuminate\Http\Request $request)
    {

        if (!$request->exists('code'))
            return redirect("/");

        $params = [
          'client_id'     => env('VK_APP_ID'),
          'client_secret' => env('VK_APP_KEY'),
          'code'          => $request->get('code'),
          'redirect_uri'  => env('VK_APP_REDIRECT'),
        ];
        $curl = new Curl(null, $params, [], "https://oauth.vk.com/access_token");
        $vkResponse = $curl->all();

        Session::put('vk_expires', $vkResponse->expires_in);
        Session::put('vk_token', $vkResponse->access_token);
        Session::put('vk_userid', $vkResponse->user_id);

        return redirect('/');
    }

    public function index(VkAds $vkAds)
    {
        $accs = $vkAds->getAccounts();
        return view('vk.accounts')->with([
          'accounts' => $accs,
          'acc' => Session::get('vk_acc')
        ]);
    }

//  public function getCompaigns($acc){
//    $curl = new Curl( 'ads.getCampaigns', ['account_id' => $acc] );
//    return view('vk.compaigns')->with(['res' => $curl->all()->response, 'acc' => $acc]);
//  }

    public function setAcc($acc)
    {
        Session::put('vk_acc', $acc);

        return redirect(route('ad.index'));
    }

    public function getAds($acc, $campaign = null)
    {
        try {
            $curl = new Curl('ads.getAds', ['account_id' => $acc, 'campaign_ids' => $campaign ? json_encode([$campaign]) : null]);

            return view('vk.ads')->with(['res' => $curl->all()->response, 'acc' => $acc, 'campaign' => $campaign]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function getAllAds($acc, VkAds $vkAds)
    {
        $code1 = '
      var ads = API.ads.getAds({"account_id": ' . $acc . '});
      var ids = "" + ads@.id[0];
      var i = 1;
      while(i < ads@.id.length){
        ids = ids + ", " + ads@.id[i];
        i = i + 1;
      }
      var stats = API.ads.getStatistics({"account_id": ' . $acc . ', "ids_type": "ad", "ids": ids, "period": "overall", "date_from": 0, "date_to": 0});
      return {"ads": ads, "stats": stats};
    ';

        $code2 = '
    var campaigns = API.ads.getCampaigns({"account_id": ' . $acc . '});
    var layouts = API.ads.getAdsLayout({"account_id": ' . $acc . '});
    return {"campaign_ids": campaigns@.id, "campaign_names": campaigns@.name, "layouts": layouts};
    ';

        $res = $this->getExecute($code1);
        usleep(550000);
        $res2 = $this->getExecute($code2);

        $ads = [];
        //важно помнить что объекты присваиваются по ссылке
        //поэтому когда по втором цикле мы изменяем каждый объект это плияет и на $ads и на $res->ads
        foreach ($res->ads as $ad) {
            $ads[$ad->id] = $ad;
        }

        foreach ($res->stats as $stat) {
            if (count($stat->stats)) {
                $ads[$stat->id]->spent = isset($stat->stats[0]->spent) ? $stat->stats[0]->spent : 0;
                $ads[$stat->id]->clicks = isset($stat->stats[0]->clicks) ? $stat->stats[0]->clicks : 0;
                $ads[$stat->id]->impressions = isset($stat->stats[0]->impressions) ? $stat->stats[0]->impressions : 1;
                $ads[$stat->id]->ctr = ($ads[$stat->id]->clicks / $ads[$stat->id]->impressions) * 100;
            } else {
                $ads[$stat->id]->spent = 0;
                $ads[$stat->id]->clicks = 0;
                $ads[$stat->id]->impressions = 0;
                $ads[$stat->id]->ctr = "н/д";
            }
        }

        return view('vk.adsAll')->with([
          'acc'                 => $acc,
          'campaigns'           => array_combine($res2->campaign_ids, $res2->campaign_names),
          'ads'                 => $res->ads,
          'layouts'             => $res2->layouts,
          'formats'             => $vkAds->getAdFormats(),
          'statuses'            => $vkAds->getStatuses(),
          'moderation_statuses' => $vkAds->getApprovedStatuses(),
          'platforms'           => $vkAds->getAdPlatforms(),
          'cost_types'          => $vkAds->getCostTypes()
        ]);
    }

    protected function getExecute($code, $assoc = false)
    {
        $curl = new Curl('execute', ['code' => $code], [], null, $assoc);

        return $assoc ? $curl->all()['response'] : $curl->all()->response;
    }
}
