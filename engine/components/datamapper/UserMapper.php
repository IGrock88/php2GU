<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 25.09.2018
 * Time: 15:55
 */

namespace engine\components\datamapper;


use engine\Models\UserModel;
use phpDocumentor\Reflection\Types\This;

class UserMapper extends AbstractMapper
{

    public function findOne($id):BaseModel
    {
        $userModel = new UserModel($this->db);
        $rowUser = $userModel->getUser($id);
        if ($rowUser != null){
            return $this->mapToUser($rowUser);
        }
        else {
            throw new \Error('user not found');
        }

    }

    private function mapToUser(array $rowUser): User
    {
        return new User($rowUser);
    }
}