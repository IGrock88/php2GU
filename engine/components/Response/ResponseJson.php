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
    protected function sendContent()
    {

        echo json_encode($this->content);
    }
}