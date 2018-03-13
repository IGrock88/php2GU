<?php
/**
 * Created by PhpStorm.
 * User: IGrock
 * Date: 08.03.2018
 * Time: 8:35
 */

namespace engine\Models;


class BasketModel extends Model
{

    private $dbBasketTable = 'basket';

    public function deleteOrderById($idOrder, $idUser)
    {
        $this->db->connect();
        $result = $this->db->delete($this->dbBasketTable, "id_order=$idOrder and id_user=$idUser");
        if($result){
            $result = $this->db->delete("orders", "id_order=$idOrder and id_user=$idUser");
        }
        $this->db->close();
        return $result;
    }

    public function getBasketTotalPrice($idUser)
    {
        $this->db->connect();
        $result = $this->db->select("SELECT sum(g.price * b.quantity) as totalPrice FROM $this->dbBasketTable as b
                                JOIN goods as g on b.id_product = g.id_product
                                WHERE id_user=$idUser and b.id_order is null")[0];
        $this->db->close();
        return $result['totalPrice'];
    }

    public function getJSONBasket($idUser)
    {
        $basketDate = $this->loadBasketGoods($idUser);
        return json_encode($basketJSON = [
            "result" => 1,
            "basket" => $basketDate['goods'],
            "total_quantity" => $basketDate['totalQuantity']
        ]);
    }

    public function addProduct($idProduct, $idUser, $quantity)
    {

        $this->db->connect();
        $productDate = $this->db->select("select * from $this->dbBasketTable where id_product='$idProduct' AND id_user='$idUser' AND id_order is null")[0];
        $this->db->close();
        $result = 0;
        if ($productDate) {

            $result = $this->updateProduct($idProduct, $idUser, ($quantity + $productDate['quantity']));
        } else {
            $result = $this->insertProduct($idProduct, $idUser, $quantity);
        }
        return $result;
    }

    public function delProduct($idProduct, $idUser)
    {
        $sql = "delete from basket WHERE id_product='$idProduct' AND id_user='$idUser' AND id_order is null";
        $this->db->connect();
        $this->db->delete($this->dbBasketTable, "id_product=$idProduct AND id_user=$idUser");
        if ($this->db->delete($this->dbBasketTable, "id_product=$idProduct AND id_user=$idUser")) {
            return true;
        }
        $this->db->close();
        return false;
    }

    public function updateProduct($idProduct, $idUser, $quantity)
    {
        $this->db->connect();
        $result = $this->db->update($this->dbBasketTable, ['quantity' => $quantity], "id_product=$idProduct and id_user=$idUser and id_order is null");
        $this->db->close();
        return $result;
    }

    public function updateOrder($idOder, $idUser)
    {
        $this->db->connect();
        $result = $this->db->update($this->dbBasketTable, ['id_order' => $idOder], "id_user=$idUser and id_order is null");
        $this->db->close();
        return $result;
    }

    private function insertProduct($idProduct, $idUser, $quantity)
    {
        $this->db->connect();
        $result = $this->db->insert($this->dbBasketTable, "id_product, quantity, id_user", [$idProduct, $quantity, $idUser]);
        $this->db->close();
        return $result;
    }

    private function loadBasketGoods($idUser)
    {
        $this->db->connect();
        $basketDate = $this->db->select("select b.id_product, b.quantity, g.price, g.img, g.title, b.id_order  from $this->dbBasketTable as b
                                          JOIN goods as g ON b.id_product=g.id_product
                                          where id_user='$idUser' AND id_order is null");
        $totalQuantity = 0;
        for ($i = 0; $i < count($basketDate); $i++) {
            $totalQuantity += $basketDate[$i]['quantity'];
        }
        $result['totalQuantity'] = $totalQuantity;
        $result['goods'] = $basketDate;
        $this->db->close();
        return $result;
    }
}