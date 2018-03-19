<?php

namespace engine\Views;


class View
{
    private $basisPage;

    public function __construct($basisPage)
    {
        $this->basisPage = $basisPage;
    }

    public function generate(array $content)
    {
        \Twig_Autoloader::register();
        $content['basesTmpl'] = $this->basisPage;

        try {
            $loader = new \Twig_Loader_Filesystem('templates/');
            $twig = new \Twig_Environment($loader);
            $template = $twig->loadTemplate($content['content']);

            echo $template->render($content);
        } catch (\Exception $e) {
            echo '<b>Мы не нашли шаблоны, но вот вам котики';
        }
    }
}