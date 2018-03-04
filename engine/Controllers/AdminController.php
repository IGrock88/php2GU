<?php

namespace engine\Controllers;


class AdminController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        if($this->content['userRole'] != 2){
            header("location: /");
        }
    }

    public function index(){
        echo "здравствуй хозяина";
    }
}