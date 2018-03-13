<?php
/**
 * Created by PhpStorm.
 * User: IGrock
 * Date: 05.03.2018
 * Time: 19:51
 */

namespace engine\Models;


class AdminModel extends Model
{
    public function getOrders(){
        $this->db->connect();
        $result = $this->db->select("select * from orders");
        $this->db->close();
        return $result;
    }

    public function deleteOrderById($idOrder)
    {
        $this->db->connect();
        $result = $this->db->delete("basket", "id_order=$idOrder");
        $this->db->close();
        return $result;
    }
}