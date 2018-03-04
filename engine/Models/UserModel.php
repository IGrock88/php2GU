<?php

namespace engine\Models;


use engine\components\Registration;
use engine\components\Auth;

class UserModel extends Model
{
    public function runRegistration(){
        $registration = new Registration($this->db);
        $registration->init();
        return $registration->getRegStatus();
    }
}