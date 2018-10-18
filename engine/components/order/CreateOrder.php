<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 22.09.2018
 * Time: 19:11
 */

namespace engine\components\order;


use engine\components\User;
use engine\db\AbstractDb;
use engine\models\BasketModel;
use engine\models\OrderModel;


class CreateOrder
{
    private $db;
    private $user;
    private $orderModel;

    public function __construct(AbstractDb $db, User $user)
    {
        $this->db = $db;
        $this->user = $user;
        $this->orderModel = new OrderModel($this->db);
    }

    // стартуем создание заказа
    public function start()
    {
        $basketPrice = $this->getBasketTotal();
        $orderId = $this->createOrder($basketPrice);
        if ($orderId) {
            if ($this->updateBasketTable($orderId)) {
                return true;
            }
        }
        return false;
    }

    // получаем сумму корзины
    private function getBasketTotal()
    {
        $basketModel = new BasketModel($this->db);
        return $basketModel->getBasketTotalPrice($this->user->getId());
    }

    // добавляем в таблицу заказов строку с заказом
    private function createOrder($basketPrice)
    {
        return $orderId = $this->orderModel->insertOrder($this->user, $basketPrice);
    }

    // добавляем в таблицу корзины напротив каждой позиции номер заказа
    private function updateBasketTable($orderId)
    {
        return $this->orderModel->updateOrder($orderId, $this->user->getId());
    }

}