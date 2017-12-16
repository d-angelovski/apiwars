<?php

namespace App\Http\Controllers;

use App\ApiEndpoint;
use App\ApiWars\ApiRepository;
use App\Vote;
use Request;
use Session;

class ApiEndpointController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function allEndpointsAjax()
    {
        $endpoints = ApiEndpoint::all();
        return $endpoints->toJson();
    }

    public function getOneRandom()
    {
        $randomEndpoint = ApiEndpoint::inRandomOrder()->first();

        return $randomEndpoint->toJson();
    }

    public function listAllRandom()
    {
        $randomEndpoint = ApiEndpoint::inRandomOrder()->first();

        $apiRepo = new ApiRepository($randomEndpoint);

        return $apiRepo->all();
    }

    public function firstRandom()
    {

        $sessId = Session::getId();

        $randomEndpoint = ApiEndpoint::inRandomOrder()->first();

        $apiRepo = new ApiRepository($randomEndpoint);

        $first = $apiRepo->first();
        $next = $apiRepo->previous();
        $next2 = $apiRepo->previous();

        $arr = array($first,$next,$next2);
        return response()->json($arr);
    }

    public function playRandom()
    {

        $sessId = Session::getId();

        // if there is voting post, save the vote to database
        if (Request::isMethod('post')) {
            if (Request::has('endpoint') && Request::has('win') && Request::has('lost')) {
                $win = new Vote;
                $win->player_session = $sessId;
                $win->api_endpoint_id = Request::get('endpoint');
                $win->name = Request::get('win');
                $win->points = 1;
                $win->save();

                $lost = new Vote;
                $lost->player_session = $sessId;
                $lost->api_endpoint_id = Request::get('endpoint');
                $lost->name = Request::get('lost');
                $lost->points = -1;
                $lost->save();
            }

        }

        // get repo from session if it exists, so that voting is on same endpoint
        if (Session::has('api_repo')) {
            $randomEndpoint = ApiEndpoint::findOrFail(Session::get('api_repo'));
        } else {
            // get random endpoint and put it in session
            $randomEndpoint = ApiEndpoint::inRandomOrder()->first();
            Session::put('api_repo', $randomEndpoint->id);
        }

        $apiRepo = new ApiRepository($randomEndpoint);

        $apiRepo->removePlayedFromUser($sessId,$randomEndpoint->id);

        $first = $apiRepo->first();
        $next = $apiRepo->next();

//        if (!empty($next)) {
//            Session::put('last_played', $next['name']);
//        }

        $arr = array($first,$next);

        $uri = request()->getRequestUri();
        if (starts_with($uri,'/json')) {
            return response()->json($arr);
        } else {
            return view('play-random', ['items' => $arr]);
        }
    }
}
