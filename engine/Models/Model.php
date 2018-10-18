<?php

namespace engine\models;


use engine\db\AbstractDb;

abstract class Model
{
    protected $db;

    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }
}