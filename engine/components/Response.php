<?php
/**
 * User: IGrock
 * Date: 02.04.2018
 * Time: 18:33
 */

namespace engine\components;


class Response
{
    private $content;
    private $statusCode;
    private $headers;
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

    public function send() {
        header('HTTP/1.1 ' . $this->statusCode);

        foreach ( $this->headers as $header ) {
            header($header);
        }

        echo $this->content;
    }

}