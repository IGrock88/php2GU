<?php

namespace engine\Views;


class View extends AbstractView
{
    private $basisPage = "templates/bases.php";

    public function generate($content)
    {
        include $this->basisPage;
    }
}