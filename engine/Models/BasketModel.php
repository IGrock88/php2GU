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

    public function getJSONBasket($idUser)
    {
        $basketDate = $this->loadBasketGoods($idUser);
        return json_encode($basketJSON = [
            "result" => 1,
            "basket" => $basketDate['goods'],
            "total_quantity" =>  $basketDate['totalQuantity']
        ]);
    }

    public function addProduct($idProduct, $idUser){

        $this->db->connect();
        $productDate = $this->db->select("select * from $this->dbBasketTable where id_product='$idProduct' AND id_user='$idUser'")[0];
        $result = 0;

        if($productDate){

            $result = $this->updateProduct($idProduct, $idUser, ++$productDate['quantity']);
        }
        else{
            $result = $this->insertProduct($idProduct, $idUser);
        }
        $this->db->close();
        return $result;
    }

    public function delProduct($idProduct, $idUser){
         $sql = "delete from basket WHERE id_product='$idProduct' AND id_user='$idUser'";
        $this->db->connect();
        $this->db->delete($this->dbBasketTable, "id_product=$idProduct AND id_user=$idUser");
        if($this->db->delete($this->dbBasketTable, "id_product=$idProduct AND id_user=$idUser")){
            return true;
        }
        return false;
    }

    public function updateProduct($idProduct, $idUser, $quantity){
        return $this->db->update($this->dbBasketTable, ['quantity' => $quantity], "id_product=$idProduct and id_user=$idUser");
    }

    private function insertProduct($idProduct, $idUser, $quantity = 1){
        return $this->db->insert($this->dbBasketTable, "id_product, quantity, id_user", [$idProduct, $quantity, $idUser]);
    }

    private function loadBasketGoods($idUser)
    {
        $this->db->connect();
        $basketDate = $this->db->select("select b.id_product, b.quantity, g.price, g.img, g.title   from $this->dbBasketTable as b
                                          JOIN goods as g ON b.id_product=g.id_product
                                          where id_user='$idUser'");
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