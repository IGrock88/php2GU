<?php

$basket = [];


function loadBasketGoods($id_user)
{
    $sql = "select * from basket where id_user='$id_user'";

    $basketDate = getAssocResult($sql);
    $link = getConnection();

    $totalQuantity = 0;
    for ($i = 0; $i < count($basketDate); $i++) {
        $id_goods = $basketDate[$i]['id_product'];
        $sql = "select * from goods where id_product='$id_goods'";
        $goodsDate = getRowResult($sql, $link);
        $basketDate[$i]['price'] = $goodsDate['price'];
        $basketDate[$i]['img'] = $goodsDate['img'];
        $basketDate[$i]['title'] = $goodsDate['title'];
        $totalQuantity += $basketDate[$i]['quantity'];
    }

    $_SESSION['basket'] = $basketDate;
    $_SESSION['basketGoodsQuantity'] = $totalQuantity;

    return $basketDate;
}

function addProduct($idProduct, $quantity = 1){
    $id_user = $_SESSION['id_user'];
    $sql = "select * from basket where id_product='$idProduct' AND id_user='$id_user'";
    $link = getConnection();
    $productDate = getRowResult($sql, $link);

    if($productDate){
        $goodsQuantity = $productDate['quantity'] + 1;
        executeQuery("UPDATE basket SET quantity='$goodsQuantity' WHERE id_product='$idProduct' AND id_user='$id_user'", $link);
        return 1;
    }
    else{
        $id_user = $_SESSION['id_user'];
        executeQuery("insert into basket (id_product, quantity, id_user) VALUES ('$idProduct', '$quantity', '$id_user')", $link);
        return 1;
    }
    return 0;
}

function delProduct($idProduct){
    $id_user = $_SESSION['id_user'];
    $sql = "delete from basket WHERE id_product='$idProduct' AND id_user='$id_user'";
    $link = getConnection();

    if(executeQuery($sql, $link)){
        return 1;
    }
    return 0;

}

function convertToJSON(){
    $basketJSON = [
      "result" => 1,
      "basket" => $_SESSION['basket'],
      "total_quantity" =>   $_SESSION['basketGoodsQuantity']

    ];
    return $basketJSON;
}

if($_POST['typeRequest'] == 'loadBasket' && $isAuth){
    loadBasketGoods($_SESSION['id_user']);
    echo json_encode(convertToJSON());
}

if($_POST['typeRequest'] == 'addProduct'){
    $result = [
        "result" => addProduct($_POST['id_product'])
    ];
    echo json_encode($result);
}
elseif ($_POST['typeRequest'] == 'delProduct'){
    $result = [
        "result" => delProduct($_POST['id_product'])
    ];
    echo json_encode($result);
}





?>