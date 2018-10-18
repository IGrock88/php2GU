<?php
/**
 * User: IGrock
 * Date: 13.03.2018
 * Time: 20:19
 */

namespace engine\models;


use engine\components\User;

class OrderModel extends Model
{
    public function loadOrderById($idUser, $idOrder)
    {
        $this->db->connect();
        $result = $this->db->select("select b.id_product, b.quantity, g.price, g.img, g.title, b.id_order  from basket as b
                                          JOIN goods as g ON b.id_product=g.id_product
                                          where id_user='$idUser' AND id_order = $idOrder");
        $this->db->close();
        return $result;
    }

    public function getOrdersByUser($idUser)
    {
        $this->db->connect();
        $result = $this->db->select("select * from orders as o
                                          JOIN order_status as os ON o.id_order_status=os.id_order_status
                                          WHERE id_user = $idUser");
        $this->db->close();
        return $result;
    }


    public function deleteOrderById($idOrder, $idUser)
    {
        $this->db->connect();
        $result = $this->db->delete("basket", "id_order=$idOrder and id_user=$idUser");
        if($result){
            $result = $this->db->delete("orders", "id_order=$idOrder and id_user=$idUser");
        }
        $this->db->close();
        return $result;
    }

    public function updateOrder($idOder, $idUser)
    {
        $this->db->connect();
        $result = $this->db->update('basket', ['id_order' => $idOder], "id_user=$idUser and id_order is null");
        $this->db->close();
        return $result;
    }

    public function insertOrder(User $user, $basketPrice)
    {
        $link = $this->db->connect();
        $result = $this->db->insert("orders", "id_user, amount", [$user->getId(), $basketPrice]);
        if ($result){
            $idOrder = mysqli_insert_id($link);
            $this->db->close();
            return $idOrder;
        }
        return false;
    }
}