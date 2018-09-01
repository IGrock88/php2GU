<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 01.09.2018
 * Time: 20:19
 */

namespace engine\components\Response;


class SendCommand implements ICommand
{
    /**
     * @var AbstractResponse
     */
    private $response;

    public function __construct(AbstractResponse $response)
    {
        $this->response = $response;
    }


    public function execute()
    {
        $this->response->send();
    }
}