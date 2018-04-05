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
    private $approvedOrderStatus = 2;
    private $notApprovedOrderStatus = 1;

    public function getOrders(){
        $this->db->connect();
        $result = $this->db->select("select * from orders");
        $this->db->close();
        return $result;
    }

    public function deleteOrderById($idOrder)
    {
        $this->db->connect();
        $result = $this->db->delete("orders", "id_order=$idOrder");
        if($result){
            $result = $this->db->delete("basket", "id_order=$idOrder");
        }
        $this->db->close();
        return $result;
    }

    public function approveOrder($idOrder)
    {
        $this->db->connect();
        $result = $this->db->update("orders",['id_order_status' => $this->approvedOrderStatus], "id_order=$idOrder");
        $this->db->close();
        return $result;
    }

    public function cancelApproveOrder($idOrder)
    {
        $this->db->connect();
        $result = $this->db->update("orders",['id_order_status' => $this->notApprovedOrderStatus], "id_order=$idOrder");
        $this->db->close();
        return $result;
    }

    public function showOrderDetail($idOrder)
    {
        $this->db->connect();
        $result = $this->db->select("select b.id_product, b.quantity, g.price, g.img, g.title, b.id_order  from basket as b
                                          JOIN goods as g ON b.id_product=g.id_product
                                          where id_order='$idOrder'");
        $this->db->close();
        return $result;
    }

    public function getGoods($startIndex, $quantityGoods = 25)
    {
        $startIndex = ($startIndex - 1) * $quantityGoods;
        $this->db->connect();
        $result = $this->db->select("select * from goods as g
                                          JOIN designer as d ON d.designer_id=g.designer
                                          JOIN goods_material as gm ON gm.id_product=g.id_product
                                          JOIN materials as m ON m.id_material=gm.id_material
                                          JOIN categoryes as c ON c.id_category=g.id_category
                                          ORDER by g.id_product limit $startIndex, $quantityGoods");
        $this->db->close();
        return $result;
    }


}