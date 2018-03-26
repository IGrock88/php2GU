<?php

namespace engine\Views;


class TwigRender implements IRender
{
    private $basisTemplate;

    public function __construct($basisTemplate = "base.tmpl")
    {
        $this->basisTemplate = $basisTemplate;
    }

    public function render(array $content)
    {
        \Twig_Autoloader::register();
        $content['basesTmpl'] = $this->basisTemplate;

        try {
            $loader = new \Twig_Loader_Filesystem('templates/');
            $twig = new \Twig_Environment($loader);
            $template = $twig->loadTemplate($content['content']);

            echo $template->render($content);
        } catch (\Exception $e) {
            echo '<b>Мы не нашли шаблоны, но вот вам котики';
        }
    }

    public function setBaseTmpl($basisTemplate)
    {
        $this->basisTemplate = $basisTemplate;
    }
}