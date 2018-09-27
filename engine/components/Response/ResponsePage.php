<?php
/**
 * User: IGrock
 * Date: 02.04.2018
 * Time: 18:33
 */

namespace engine\components\response;


class ResponsePage extends AbstractResponse
{
    protected function sendContent()
    {
        echo $this->content;
    }

}