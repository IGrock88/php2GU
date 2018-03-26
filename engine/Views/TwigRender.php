<?php

namespace engine\Views;


class TwigRender implements IRender
{

    public function render($basisTemplate, array $content)
    {
        \Twig_Autoloader::register();
        $content['basesTmpl'] = $basisTemplate;

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