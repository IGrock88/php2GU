<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 25.09.2018
 * Time: 14:23
 */

namespace engine\components\datamapper;


class User extends BaseModel
{

    /**
     * @property integer $id_user
     * @property string $login
     * @property string $name
     * @property string $pass
     * @property string $prim
     * @property integer $id_role
     *
     * @property Role $role
     */

    private $role = null;

    public function getRole()
    {
        if ($this->role = null){
            $this->role =
        }
    }

}