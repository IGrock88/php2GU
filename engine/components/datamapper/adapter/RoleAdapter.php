<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 25.09.2018
 * Time: 16:50
 */

namespace engine\components\datamapper\adapter;


class RoleAdapter extends AbstractAdapter
{

    public function findOne($id)
    {
        $this->db->connect();
        $result = $this->db->select("select * from user_role where id_role = $id")[0];
        $this->db->close();
        return $result;
    }
}