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
use engine\Views\IRenderAdapter;

class ControllerBuilder
{
    protected $render;
    protected $auth;
    protected $request;
    protected $db;

    /**
     * @return IRenderAdapter
     */
    public function getRender(): IRenderAdapter
    {
        return $this->render;
    }

    /**
     * @param IRenderAdapter $render
     */
    public function setRender(IRenderAdapter $render)
    {
        $this->render = $render;
    }

    /**
     * @return Auth
     */
    public function getAuth(): Auth
    {
        return $this->auth;
    }

    /**
     * @param Auth $auth
     */
    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return AbstractDb
     */
    public function getDb() : AbstractDb
    {
        return $this->db;
    }

    /**
     * @param AbstractDb $db
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