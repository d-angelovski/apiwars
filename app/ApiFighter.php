<?php

namespace App;


class ApiFighter implements \JsonSerializable
{

    protected $name;
    protected $api_endpoint_id;
    protected $api_title;
    protected $votes;
    protected $image;

    /**
     * ApiFighter constructor.
     */
    public function __construct(Array $properties)
    {
        $this->name = $properties['name'];
        $this->api_endpoint_id = $properties['api_endpoint_id'];
        $this->api_title = $properties['api_title'];
        $this->votes = $properties['votes'];
        $this->image = $properties['image'];
    }

    /**
     * @return mixed
     */
    public function getApiEndpointId()
    {
        return $this->api_endpoint_id;
    }

    /**
     * @param mixed $api_endpoint_id
     */
    public function setApiEndpointId($api_endpoint_id)
    {
        $this->api_endpoint_id = $api_endpoint_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getApiTitle()
    {
        return $this->api_title;
    }

    /**
     * @param mixed $api_title
     */
    public function setApiTitle($api_title)
    {
        $this->api_title = $api_title;
    }

    /**
     * @return mixed
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param mixed $votes
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}