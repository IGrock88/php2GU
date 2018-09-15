<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 15.09.2018
 * Time: 17:19
 */

namespace engine\Views;


interface IRenderAdapter
{

    public function render($content);
    public function setBaseTmpl($template);
}