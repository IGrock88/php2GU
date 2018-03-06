<?php

namespace engine\Views;


class View extends AbstractView
{
    private $basisPage = "base.tmpl";

    public function generate($content)
    {
//        include "templates/bases.php";
        \Twig_Autoloader::register();
        $content['basesTmpl'] = $this->basisPage;
        try {
            $loader = new \Twig_Loader_Filesystem('twigtemplates/');
            $twig = new \Twig_Environment($loader);
            $template = $twig->loadTemplate($content['content']);
            echo $template->render($content);
        } catch (Exception $e) {
            echo '<b>Мы не нашли шаблоны, но вот вам котики';

        }
    }
}