<?php
/**
 * Created by PhpStorm.
 * User: egolife
 * Date: 12.06.2015
 * Time: 22:48
 */

namespace App;


use Illuminate\Support\Facades\Session;

class VkAds
{

    protected $results = null;

    protected $ad_formats = [
      1 => 'изображение и текст',
      2 => 'большое изображение',
      3 => 'эксклюзивный формат',
      4 => 'продвижение сообщенств',
      5 => 'приложение в новост ленте'
    ];

    protected $cost_types = [
      0 => 'оплата за переходы',
      1 => 'оплата за показы'
    ];

    protected $ad_platforms = [
      0 => 'ВК и сайты партнеры',
      1 => 'Только ВК'
    ];

    protected $statuses = [
      0 => 'объявление остановлено',
      1 => 'объявление запущено',
      2 => 'объявление удалено',
    ];

    protected $approved_statuses = [
      0 => 'объявление не проходило моделацию',
      1 => 'объявление ожидает модерации',
      2 => 'объявление одобрено',
      3 => 'объявление отклонено'
    ];

    /**
     * @return array
     */
    public function getAdFormats()
    {
        return $this->ad_formats;
    }

    /**
     * @return array
     */
    public function getCostTypes()
    {
        return $this->cost_types;
    }

    /**
     * @return array
     */
    public function getAdPlatforms()
    {
        return $this->ad_platforms;
    }

    /**
     * @return array
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * @return array
     */
    public function getApprovedStatuses()
    {
        return $this->approved_statuses;
    }

    public function getAccounts()
    {
        if (!Session::has('accounts')) {
            $curl = new Curl('ads.getAccounts');
            Session::put('accounts', $curl->all()->response);
        }

        return Session::get('accounts');
    }

    public function all($acc)
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

        $res = $this->getExecute($code1);

        $ads = [];
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

        return $res->ads;
    }

    public function retrieveResults($acc)
    {
        $code = '
            var campaigns = API.ads.getCampaigns({"account_id": ' . $acc . '});
            var layouts = API.ads.getAdsLayout({"account_id": ' . $acc . '});
            return {"campaign_ids": campaigns@.id, "campaign_names": campaigns@.name, "layouts": layouts};
        ';
        $this->results = $this->getExecute($code);
    }

    public function getLayouts()
    {
        return $this->results->layouts;
    }

    public function getCampaigns()
    {
        return array_combine($this->results->campaign_ids, $this->results->campaign_names);
    }

    protected function getExecute($code, $assoc = false)
    {
        $curl = new Curl('execute', ['code' => $code], [], null, $assoc);

        return $assoc ? $curl->all()['response'] : $curl->all()->response;
    }

}