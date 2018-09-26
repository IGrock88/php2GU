<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 25.09.2018
 * Time: 16:24
 */

namespace engine\components\datamapper;


class RoleMapper extends AbstractMapper
{

    public function findOne($id): BaseModel
    {
        // TODO: Implement findOne() method.
    }

    private function mapToRole(array $role): Role
    {
        return new Role($role);
    }
}