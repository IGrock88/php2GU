<?php

namespace engine\Models;


use engine\components\Registration;
use engine\components\Auth;
use engine\DB\DB;

class UserModel extends Model
{
    public function runRegistration(){
        $registration = new Registration($this->db);
        $registration->init();
        return $registration->getRegStatus();
    }

    public function checkout($idUser){
        $basketModel = new BasketModel($this->db);
        $basketPrice = $basketModel->getBasketTotalPrice($idUser);
        $result= 0;

        if($basketPrice){
            $link = $this->db->connect();
            $this->db->insert("orders", "id_user, amount", [$idUser, $basketPrice]);
            $orderId = mysqli_insert_id($link);
            $result = $basketModel->updateOrder($orderId, $idUser);
        }
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



}