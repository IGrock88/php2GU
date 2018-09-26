<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 25.09.2018
 * Time: 10:38
 */

namespace engine\components\datamapper;


use engine\components\datamapper\BaseModel;
use engine\DB\AbstractDb;
use engine\Models\AbstractModel;

abstract class AbstractMapper
{
    protected $db;

    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }

    abstract public function findOne($id): BaseModel;

}