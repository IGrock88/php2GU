<?php

namespace engine\components;


class User
{
    private $login = "";
    private $role = 1;
    private $name = "";
    private $id = "";

    public function __construct($login, $role, $name, $id)
    {
        $this->login = $login;
        $this->role = $role;
        $this->name = $name;
        $this->id = $id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }


}