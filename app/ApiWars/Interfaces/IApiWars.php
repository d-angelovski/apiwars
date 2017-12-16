<?php

namespace App\ApiWars\Interfaces;


interface IApiWars
{

    public function count();

    public function storeToCache();

    public function fetchAll();

    public function all();

    public function first();

    public function last();

    public function random();

    public function search($term);

    public function next();

    public function previous();

    public function fillUpPlayedFromDatabase($apiId);

    public function removePlayedFromUser($userid, $apiId);
}