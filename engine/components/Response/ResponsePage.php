<?php
/**
 * User: IGrock
 * Date: 02.04.2018
 * Time: 18:33
 */

namespace engine\components\response;


class ResponsePage extends AbstractResponse
{
    public function send() {
        header('HTTP/1.1 ' . $this->statusCode);

        foreach ( $this->headers as $header ) {
            header($header);
        }
        echo $this->content;
    }

}