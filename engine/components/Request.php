<?php

namespace engine\components;


class Request
{
    private $postParams;
    private $files;
    private $url;

    public function __construct()
    {
        $this->postParams = $_POST;
        $this->files = $_FILES;
        $this->url = explode("/", $_SERVER['REQUEST_URI']);
    }

    public function getPostParams()
    {
        return $this->postParams;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getItemId()
    {
        return $this->url[3];
    }


}