<?php

namespace App\Http\Controllers;

use App\Curl;
use App\VkAds;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdvertController extends Controller
{
    public function __construct()
    {
        $this->middleware('vk.acc');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(VkAds $vkAds)
    {
        $acc = Session::get('vk_acc');
        $ads = $vkAds->all($acc);
        usleep(550000);
        $vkAds->retrieveResults($acc);
        $layouts = $vkAds->getLayouts();
        $campaigns = $vkAds->getCampaigns();

        return view('vk.adsAll')->with([
        'acc'                 => $acc,
        'accounts'            => $vkAds->getAccounts(),
        'campaigns'           => $campaigns,
        'ads'                 => $ads,
        'layouts'             => $layouts,
        'formats'             => $vkAds->getAdFormats(),
        'statuses'            => $vkAds->getStatuses(),
        'moderation_statuses' => $vkAds->getApprovedStatuses(),
        'platforms'           => $vkAds->getAdPlatforms(),
        'cost_types'          => $vkAds->getCostTypes()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $curlCampaigns = new Curl('ads.getCampaigns', ['account_id' => Session::get('vk_acc')]);
        $curlCategories = new Curl('ads.getCategories');

        return view('vk.createAd')->with([
        'campaigns'  => $curlCampaigns->lists('name', 'id'),
        'categories' => $curlCategories->lists('name', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
