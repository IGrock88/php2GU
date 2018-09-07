<?php

namespace engine\Controllers;

use engine\components\Auth;
use engine\components\Builder\ControllerBuilder;
use engine\components\Request;
use engine\DB\AbstractDb;
use engine\Views\IRender;


abstract class AbstractController
{
    /**
     * @property IRender $render
     * @property Auth $auth
     * @property Request $request
     * @property AbstractDb $db
     */
    protected $content;
    protected $render;
    protected $auth;
    protected $request;
    protected $db;

    public function __construct(ControllerBuilder $builder)
    {

        $this->render = $builder->getRender();
        $this->auth = $builder->getAuth();
        $this->request = $builder->getRequest();
        $this->db = $builder->getDb();
        $this->content['isAuth'] = $this->auth->isAuth();
        $this->content['user'] = $this->auth->getUser();

    }

}