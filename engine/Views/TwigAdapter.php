<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 15.09.2018
 * Time: 17:21
 */

namespace engine\Views;


class TwigAdapter implements IRenderAdapter
{
    private $render;

    public function __construct(IRender $render)
    {
        $this->render = $render;
    }

    public function render($content)
    {
        return $this->render->render($content);
    }

    public function setBaseTmpl($template)
    {
        $this->render->setBaseTmpl($template);
    }
}