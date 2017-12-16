<?php

namespace App\Http\Controllers;

use App\ApiEndpoint;
use App\ApiWars\ApiRepository;
use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // remove api_repository ID from session
        if (Session::has('api_repo')) {
            Session::flush();
        }

        // get all api repos and join the alldatas
        $allRepos = array();
        foreach (ApiEndpoint::all() as $api) {
            $apiRepo = new ApiRepository($api);
            if (is_array($apiRepo->all())) {
                $allRepos = array_merge($allRepos, $apiRepo->all());
            }
        }

        // sort by votes desc
        usort($allRepos, function($a, $b){
            return $b["votes"] - $a["votes"];
        });


        // percentage calculations
        $allVotesCount = 0;
        foreach ($allRepos as $repo) {
            // we dont consider the negatives
            if ($repo['votes'] > 0) {
                $allVotesCount += $repo['votes'];
            }
        }
        foreach ($allRepos as $key => $repo) {
            $allRepos[$key]['percent'] = ($repo['votes'] > 0) ?
                round($repo['votes'] / $allVotesCount * 100, 0) :
                0;
        }

        return view('index', ['items'=> $allRepos]);
    }

    public function cacheApis()
    {
        // get all api repos and join the alldatas
        foreach (ApiEndpoint::all() as $api) {
            $apiRepo = new ApiRepository($api);
            $apiRepo->storeToCache();
        }

        return "Stored api endpoints to cache.";
    }
}
