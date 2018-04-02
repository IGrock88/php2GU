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
    private $status_code;
    private $headers;
    const DEFAULT_STATUS_CODE = 200;

    public function __construct($content, $status_code = self::DEFAULT_STATUS_CODE, $headers = [])
    {
        $this->content = $content;
        $this->status_code = $status_code;
        $this->headers = $headers;
    }

    public function setStatusCode($status_code) {
        $this->status_code = $status_code;
    }

    public function setHeader($header) {
        $this->headers[] = $header;
    }

    public function send() {
        header('HTTP/1.1 ' . $this->status_code);

        foreach ( $this->headers as $header ) {
            header($header);
        }

        echo $this->content;
    }

}