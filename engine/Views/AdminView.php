<?php

namespace engine\Views;


class AdminView extends AbstractView
{

    private $basisPage = "templates/adminBase.php";

    public function generate($content)
    {
        include $this->basisPage;
    }
}