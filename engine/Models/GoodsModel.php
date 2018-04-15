<?php

namespace engine\Models;


use engine\components\Registration;
use engine\components\Auth;
use engine\DB\DB;

class GoodsModel extends Model
{
    private $goodsTable = "goods";
    const DEFAULT_SHOW_CATEGORY_GOODS = 9;

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

    public function getGoodsByCategory($idCategory, $startIndex = 0, $quantity = SELF::DEFAULT_SHOW_CATEGORY_GOODS)
    {
        $this->db->connect();
        $result = $this->db->select("select * from $this->goodsTable WHERE id_category=$idCategory limit $startIndex, $quantity");
        $this->db->close();
        return $result;
    }

    public function getGoodsQuantityByCategory($idCategory)
    {
        $this->db->connect();
        $result = $this->db->select("SELECT count(*) as quantity FROM goods WHERE id_category=$idCategory")[0]['quantity'];
        $this->db->close();
        return $result;
    }

    public function getDesigner()
    {
        $this->db->connect();
        $result = $this->db->select("select * from designer");
        $this->db->close();
        return $result;
    }

    public function getCategories()
    {
        $this->db->connect();
        $result = $this->db->select("select * from categoryes");
        $this->db->close();
        return $result;
    }
}