<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 01.09.2018
 * Time: 18:28
 */

namespace engine\components\Response;


abstract class AbstractResponse
{

    protected $content;
    protected $statusCode;
    protected $headers;
    const DEFAULT_STATUS_CODE = 200;

    public function __construct($content, $statusCode = self::DEFAULT_STATUS_CODE, $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }

    public function setHeader($header) {
        $this->headers[] = $header;
    }

    abstract public function send();
}