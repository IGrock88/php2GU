<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 01.09.2018
 * Time: 18:25
 */

namespace engine\components\Response;


class ResponseJson extends AbstractResponse
{
    public function send() {
        header('HTTP/1.1 ' . $this->statusCode);

        foreach ( $this->headers as $header ) {
            header($header);
        }

        echo json_encode($this->content);
    }
}