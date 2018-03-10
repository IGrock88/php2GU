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

    public function loadBasketGoods($idUser)
    {
        $this->db->connect();
        $basketDate = $this->db->select("select b.id_product, b.quantity, g.price, g.img, g.title from basket as b
                                          JOIN goods as g ON b.id_product=g.id_product
                                          where id_user='$idUser'");
        $totalQuantity = 0;
        for ($i = 0; $i < count($basketDate); $i++) {
            $totalQuantity += $basketDate[$i]['quantity'];
        }
        $basketJSON = [
            "result" => 1,
            "basket" => $basketDate,
            "total_quantity" =>  $totalQuantity

        ];
        return json_encode($basketJSON);
    }

    public function addProduct($idProduct, $idUser, $quantity = 1){

        $this->db->connect();
        $productDate = $this->db->select("select * from basket where id_product='$idProduct' AND id_user='$idUser'");
        $result = 0;

        if($productDate){
            $result = $this->updateProduct($idProduct, $idUser, $quantity);
        }
        else{
            $result = $this->insertProduct($idProduct, $idUser, $quantity);
        }
        $this->db->close();
        return $result;
    }



    public function delProduct($idProduct){
        $id_user = $_SESSION['id_user'];
        $sql = "delete from basket WHERE id_product='$idProduct' AND id_user='$id_user'";
        $link = getConnection();

        if(executeQuery($sql, $link)){
            return 1;
        }
        return 0;

    }

    private function convertToJSON(){
        $basketJSON = [
            "result" => 1,
            "basket" => $_SESSION['basket'],
            "total_quantity" =>   $_SESSION['basketGoodsQuantity']

        ];
        return json_encode($basketJSON);
    }

    private function insertProduct($idProduct, $idUser, $quantity = 1){
        executeQuery("insert into basket (id_product, quantity, id_user) VALUES ('$idProduct', '$quantity', '$idUser')");
        return 1;
    }

    private function updateProduct($idProduct, $idUser, $quantity = 1){
        executeQuery("UPDATE basket SET quantity='$quantity' WHERE id_product='$idProduct' AND id_user='$idUser'");
        return 1;
    }


}