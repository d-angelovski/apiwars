<?php

namespace App\ApiWars\Traits;

use App\ApiFighter;
use App\Vote;
use DB;

trait TApiWars
{

    protected $current;
    protected $alldata;

    public function first()
    {
        // get the first from alldata
        if (count($this->alldata)) {
            $this->current = new ApiFighter($this->alldata[0]);
            return $this->current;
        }

        return null;
    }

    public function last()
    {
        // get the last from alldata
        if (count($this->alldata)) {
            $last = $this->alldata[count($this->alldata) - 1];
            $this->current = new ApiFighter($last);
            return $this->current;
        }

        return null;
    }

    public function search($term)
    {
        if (count($this->alldata)) {
            foreach ($this->alldata as $item) {
                if ($term === $item['name']) {
                    $this->current = new ApiFighter($item);
                    return $this->current;
                }
            }
        }

        return null;
    }

    public function next()
    {
        if (count($this->alldata)) {
            $return = reset($this->alldata); // set on first element
            if (isset($this->current)) {
                foreach ($this->alldata as $index => $current) {
                    // if current element is found in array
                    if ($current == $this->current->jsonSerialize()) {
                        if (array_key_exists($index + 1, $this->alldata)) {
                            // return next array element
                            $return = $this->alldata[$index + 1];
                            break;
                        }
                    }
                }
            }
            $this->current = new ApiFighter($return);
            return $return;
        }

        return null;
    }

    public function previous()
    {
        if (count($this->alldata)) {
            $return = end($this->alldata); // set on last element
            if (isset($this->current)) {
                foreach ($this->alldata as $index => $current) {
                    // if current element is found in array
                    if ($current == $this->current->jsonSerialize()) {
                        if (array_key_exists($index - 1, $this->alldata)) {
                            // return previos array element
                            $return = $this->alldata[$index - 1];
                            break;
                        }
                    }
                }
            }
            $this->current = new ApiFighter($return);
            return $return;
        }

        return null;
    }

    public function removePlayedFromUser($userid, $apiId)
    {
        $userVotes = DB::table('votes')
            ->select('player_session', 'name')
            ->where('player_session','=', $userid)
            ->where('api_endpoint_id','=', $apiId)
            ->groupBy('name', 'player_session')
            ->orderBy('name','asc')
            ->get();

        foreach ($userVotes as $vote){
            for ($i=0; $i < count($this->alldata); $i++) {
                if ($this->alldata[$i]['name'] == $vote->name) {
                    unset($this->alldata[$i]);
                    // reindex
                    $this->alldata = array_values($this->alldata);
                }
            }
        }
    }

    public function count()
    {
        if (isset($this->alldata)) {
            return count($this->alldata);
        }

        return 0;
    }

    public function all()
    {
        return $this->alldata;
    }

    public function fillUpPlayedFromDatabase($apiId)
    {
        $votes = DB::table('votes')
            ->select('name', DB::raw('SUM(`points`) as votes'))
            ->where('api_endpoint_id','=', $apiId)
            ->groupBy('name')
            ->orderBy('votes','desc')
            ->get();

        foreach ($votes as $vote){
            for ($i=0; $i < count($this->alldata); $i++) {
                if ($this->alldata[$i]['name'] == $vote->name) {
                    $this->alldata[$i]['votes'] = $vote->votes * 1;
                    break;
                }
            }
        }

        // sort by votes desc
        usort($this->alldata, function($a, $b){
            return $b["votes"] - $a["votes"];
        });
    }

    public function random()
    {
        if (count($this->alldata)) {
            $randIndex = array_rand($this->alldata);
            return $this->alldata[$randIndex];
        }

        return null;
    }

}