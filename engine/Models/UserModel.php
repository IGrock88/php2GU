<?php

namespace engine\Models;



use engine\components\order\CreateOrder;
use engine\components\User;

class UserModel extends Model
{
    public function runRegistration(){
        $registration = new Registration($this->db);
        $registration->init();
        return $registration->getRegStatus();
    }

    public function createOrder(User $user){

        $createOrder = new CreateOrder($this->db, $user);
        $result = $createOrder->start();

//        $idUser = $user->getId();
//        $basketModel = new BasketModel($this->db);
//        $basketPrice = $basketModel->getBasketTotalPrice($idUser);
//        $result= 0;
//
//        if($basketPrice){
//            $link = $this->db->connect();
//            mysqli_begin_transaction($link);
//            $this->db->insert("orders", "id_user, amount", [$idUser, $basketPrice]);
//            $orderId = mysqli_insert_id($link);
//            $orderModel = new OrderModel($this->db);
//            $result = $orderModel->updateOrder($orderId, $idUser);
//            mysqli_commit($link);
//        }
        return $result;
    }



}