<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 01.09.2018
 * Time: 20:27
 */

namespace engine\components\Response;


class Invoker
{
    private $command;

    public function __construct(ICommand $command)
    {
        $this->command = $command;
    }

    public function sendResponse()
    {
        $this->command->execute();
    }
}