<?php

namespace engine\Views;


abstract class AbstractView
{
    private $basisPage;
    abstract public function generate($content);
}