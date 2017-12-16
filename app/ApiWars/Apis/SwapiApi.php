<?php

namespace App\ApiWars\Apis;


use App\ApiEndpoint;
use App\ApiWars\Interfaces\IApiWars;
use App\ApiWars\Traits\TApiWars;
use Cache;
use GuzzleHttp\Client;

class SwapiApi implements IApiWars
{
    use TApiWars;

    protected $endpoint;
    protected $page;


    /**
     * SwapiApi constructor.
     */
    public function __construct(ApiEndpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        $pages = env('APP_CACHE_PAGES',5);
        $minutes = env('APP_CACHE_MINUTES',120);

        // get it from cache
        if (Cache::has($endpoint->path)) {
            $this->alldata = Cache::get($endpoint->path);

            // fill votes from database
            $this->fillUpPlayedFromDatabase($endpoint->id);
        }
    }

    public function storeToCache()
    {
        $pages = env('APP_CACHE_PAGES',5);

        if (Cache::has($this->endpoint->path)) {
            Cache::delete($this->endpoint->path);
        }

        // grab all data from the endpoint
        // for usage sake, take only first few pages
        $this->alldata = array();
        for ($i = 0; $i < $pages; $i++) {
            $arr = $this->fetchAll($i);
            if (!empty($arr) && is_array($arr['results'])) {
                foreach ($arr['results'] as $res) {
                    $properties = array(
                        'name' => $res['name'],
                        'api_endpoint_id' => $this->endpoint->id,
                        'api_title' => $this->endpoint->name,
                        'image' => '',
                        'votes' => 0,
                    );
                    array_push($this->alldata, $properties);
                }
            } else {
                continue;
            }
        }
        Cache::forever($this->endpoint->path, $this->alldata);
    }

    public function fetchAll($page = 0)
    {
        $this->page = $page;
        $client = new Client(['base_uri' => $this->endpoint->path]);
        $response = $client->request('GET', '?page=' . ($this->page + 1), ['http_errors' => false]);
        $body = $response->getBody();
        $content = $body->getContents();
        $code = $response->getStatusCode();
        $arr = json_decode($content, TRUE);

        if ($code === 200) {
            return $arr;
        }

        return null;
    }


}