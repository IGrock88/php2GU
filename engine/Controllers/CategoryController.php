<?php
/**
 * Created by PhpStorm.
 * User: IGrock
 * Date: 07.03.2018
 * Time: 19:50
 */

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