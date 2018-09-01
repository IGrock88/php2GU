<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 01.09.2018
 * Time: 20:12
 */

namespace engine\components\Response;


interface ICommand
{

    public function execute();
}