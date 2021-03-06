<?php

namespace engine\components;

use engine\db\AbstractDb;

class Auth
{
    private $user;
    private $db;
    private $isAuth = false;
    private $requests;

    public function __construct(AbstractDb $db, Request $request)
    {
        session_start();
        $this->db = $db;
        $this->requests = $request;
        $this->init();

    }

    /**
     * @return User|mixed
     *
     */
    public function getUser()
    {
        return $this->user;
    }

    public function isAuth()
    {
        return $this->isAuth;
    }

    private function init()
    {
        if (isset($this->requests->getPostParams()['SubmitLogin']))   //Если попытка авторизации через форму, то пытаемся авторизоваться
        {
            $this->isAuth = $this->authWithCredential($_POST['login'], $_POST['pass']);
        }
        elseif (isset($_SESSION['IdUserSession']))    //иначе пытаемся авторизоваться через сессии
        {
            $this->isAuth = $this->checkAuthWithSession($_SESSION['IdUserSession']);
        }
        else // В последнем случае пытаемся авторизоваться через cookie
        {
            $this->isAuth = $this->checkAuthWithCookie();
        }
        if (isset($this->requests->getPostParams()['ExitLogin']))
        {
            $this->isAuth = $this->userExit();
        }

        if($this->isAuth) {
            $userRole = $this->checkUserRole($_SESSION['login']);
            $this->user = new User($_SESSION['login'], $userRole, $_SESSION['name'], $_SESSION['id_user']);
        }


    }

    private function userExit()
    {
        if (isset($_SESSION['IdUserSession'])){
            $IdUserSession = $_SESSION['IdUserSession'];
            $this->db->connect();

            $this->db->delete('users_auth', "hash_cookie = $IdUserSession");
            $this->db->close();
        }




        unset($_SESSION['id_user']);
        unset($_SESSION['IdUserSession']);
        unset($_SESSION['login']);
        $this->login = "";
        unset($_SESSION['pass']);
        unset($_SESSION['basket']);
        unset($_SESSION['basketGoodsQuantity']);
        //setcookie('idUserCookie','', time() - 3600 * 24 * 7);

        return $this->isAuth = false;
    }

    private function authWithCredential($userName, $password)
    {
        $isAuth = false;
        $this->db->connect();
        $userDate = $this->db->select("select id_user, login, name, pass from users where login = '$userName'")[0];

        if ($userDate)
        {
            $passHash = $userDate['pass'];
            $id_user = $userDate['id_user'];
            $idUserCookie = microtime(true) . rand(100,1000000);
            if (password_verify($password, $passHash))
            {

                $_SESSION['id_user'] = $id_user;
                $_SESSION['IdUserSession'] = $idUserCookie;
                $_SESSION['login'] = $userName;
                $_SESSION['name'] = $userDate['name'];
                $this->db->insert('users_auth', "id_user, hash_cookie, prim", [$id_user, $idUserCookie, '123456789']);
                $this->db->close();
                $isAuth = true;

                if (isset($_POST['rememberme'])){
                    if ($_POST['rememberme']){
                        setcookie('idUserCookie',$idUserCookie, time() + 3600 * 24 * 7);
                    }
                }
            }
            else
            {
                $this->userExit();
            }
        }
        else
        {
            $this->userExit();
        }
        return $isAuth;
    }

    private function checkAuthWithSession($IdUserSession)
    {
        $isAuth = false;
        $hash_cookie = $IdUserSession;
        $this->db->connect();
        $userDate = $this->db->select("select * from users_auth where hash_cookie = '$hash_cookie'");
        $this->db->close();

        if ($userDate){
            $isAuth = true;
            $_SESSION['IdUserSession'] = $IdUserSession;
        }
        else{
            $this->isAuth = false;
            $this->userExit();
        }
        return $isAuth;
    }

    private function checkAuthWithCookie()
    {
        $isAuth = false;

        if (isset($_COOKIE['idUserCookie'])){
            $idUserCookie = $_COOKIE['idUserCookie'];
            $hash_cookie = $idUserCookie;
            $this->db->connect();
            $userDate = $this->db->select("select * from users_auth where hash_cookie = '$hash_cookie'");
            $this->db->close();
        }



        if (!empty($userDate))
        {
            $this->checkAuthWithSession($idUserCookie);
            $isAuth = true;
        }
        else
        {
            $isAuth = false;
            $this->userExit();;
        }

        return $isAuth;
    }

    private function checkUserRole($login){
        $this->db->connect();
        $userRole = $this->db->select("select id_role from users where login = '$login'")[0]['id_role'];
        $this->db->close();
        return $userRole;
    }

}