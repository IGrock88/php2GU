<?php

namespace engine\components;

use engine\DB\AbstractDb;


class Registration
{
    private $db;
    const REG_STATUS_NO_REG = 0;
    const REG_STATUS_SUCCESS = 1;
    const REG_STATUS_LOGIN_IS_USE = 2;
    private $regStatus = self::REG_STATUS_NO_REG;

    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }

    public function getRegStatus()
    {
        return $this->regStatus;
    }

    public function init()
    {
        if ($_POST['regNewUser']){
           $this->regNewUser($_POST['regLogin'], $_POST['regPass'], $_POST['regName']);
        }
    }


    private function regNewUser($login, $pass, $name){
        if($this->checkLogin($login)){
            $this->regStatus = self::REG_STATUS_LOGIN_IS_USE;
            return;
        }
        $passHash = password_hash($pass, PASSWORD_DEFAULT);
        $result = $this->db->insert(USER_DB_TABLE, "login, name, pass", [$login, $name, $passHash]);
        if($result){
            $this->regStatus = self::REG_STATUS_SUCCESS;
        }
        $this->db->close();
    }

    private function checkLogin($login){
        $this->db->connect();
        return $this->db->select("select login from Users where login = '$login'");
    }



}