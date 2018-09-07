<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 07.09.2018
 * Time: 10:47
 */

namespace engine\components\Builder;


use engine\components\Auth;
use engine\components\Request;
use engine\Controllers\AbstractController;
use engine\DB\AbstractDb;
use engine\Views\IRender;

class ControllerBuilder
{
    protected $render;
    protected $auth;
    protected $request;
    protected $db;

    /**
     * @return mixed
     */
    public function getRender(): IRender
    {
        return $this->render;
    }

    /**
     * @param mixed $render
     */
    public function setRender(IRender $render)
    {
        $this->render = $render;
    }

    /**
     * @return mixed
     */
    public function getAuth(): Auth
    {
        return $this->auth;
    }

    /**
     * @param mixed $auth
     */
    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getDb() : AbstractDb
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     */
    public function setDb(AbstractDb $db)
    {
        $this->db = $db;
    }

    public function build(string $controller): AbstractController
    {
        return new $controller($this);
    }
}