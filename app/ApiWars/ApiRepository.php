<?php


namespace App\ApiWars;


use App\ApiEndpoint;
use App\ApiWars\Interfaces\IApiWars;

class ApiRepository
{

    protected $api;

    /**
     * ApiRepository constructor.
     */
    public function __construct(ApiEndpoint $endpoint)
    {
        $apiClassName = 'App\\ApiWars\\Apis\\'.$endpoint->service;
        if( class_exists($apiClassName)){
            $this->api = new $apiClassName($endpoint);
        }
    }

    public function all()
    {
        if(isset($this->api)) {
            return $this->api->all();
        }
        return null;
    }

    public function storeToCache()
    {
        if(isset($this->api)) {
            $this->api->storeToCache();
        }
    }

    public function first()
    {
        if(isset($this->api)) {
            return $this->api->first();
        }
        return null;
    }

    public function last()
    {
        if(isset($this->api)) {
            return $this->api->last();
        }
        return null;
    }

    public function search($term)
    {
        if(isset($this->api)) {
            return $this->api->search($term);
        }
        return null;
    }

    public function next()
    {
        if(isset($this->api)) {
            return $this->api->next();
        }
        return null;
    }

    public function previous()
    {
        if(isset($this->api)) {
            return $this->api->previous();
        }
        return null;
    }

    public function removePlayedFromUser($userId, $apiId)
    {
        if(isset($this->api)) {
            return $this->api->removePlayedFromUser($userId, $apiId);
        }
        return null;
    }
}