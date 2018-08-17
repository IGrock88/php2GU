<?php

namespace engine\Models;


use engine\DB\AbstractDb;

abstract class Model
{
    protected $db;

    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }
}