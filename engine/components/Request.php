<?php
/**
 * Created by PhpStorm.
 * User: IGrock
 * Date: 10.03.2018
 * Time: 10:13
 */

namespace engine\components;


class Request
{
    private $postParams;
    private $files;

    public function __construct()
    {
        $this->postParams = $_POST;
        $this->files = $_FILES;
    }

    public function getPostParams()
    {
        return $this->postParams;
    }

    public function getFiles()
    {
        return $this->files;
    }
}