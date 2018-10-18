<?php
/**
 * User: IGrock
 * Date: 26.03.2018
 * Time: 19:29
 */

namespace engine\views;


interface IRender
{
    public function render(array $content);
    public function setBaseTmpl($basisTemplate);
}