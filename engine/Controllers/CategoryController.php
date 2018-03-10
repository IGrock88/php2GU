<?php

namespace engine\Controllers;


class CategoryController extends Controller
{
    public function man(){
        $this->content['content'] = 'pages/category.tmpl';
        $this->view->generate($this->content);
    }

    public function women(){
        $this->content['content'] = 'pages/category.tmpl';
        $this->view->generate($this->content);
    }
}