<?php

namespace engine\Models;


use engine\components\Registration;
use engine\components\Auth;
use engine\DB\DB;

class GoodsModel extends Model
{
    private $goodsTable = "goods";

    public function getFeatureGoods($quantityGoods, $startIndex = 0)
    {
        $this->db->connect();
        $result = $this->db->select("select * from $this->goodsTable order by view desc, date desc limit $startIndex, $quantityGoods;");
        $this->db->close();
        return $result;
    }

    public function getGoodsById($idGoods)
    {
        $this->db->connect();
        $result = $this->db->select("select * from $this->goodsTable as g
                                          JOIN designer as d ON d.designer_id=g.designer
                                          JOIN goods_material as gm ON gm.id_product=g.id_product
                                          JOIN materials as m ON m.id_material=gm.id_material
                                          JOIN categoryes as c ON c.id_category=g.id_category
                                          where g.id_product=$idGoods;");
        $this->db->close();
        return $result[0];
    }

    public function getGoodsByCategory($idCategory)
    {
        $this->db->connect();
        $result = $this->db->select("select * from $this->goodsTable WHERE id_category=$idCategory");
        $this->db->close();
        return $result;
    }

}