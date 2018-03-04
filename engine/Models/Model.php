<?php

namespace engine\Models;


use engine\DB\DB;

class Model
{
    protected $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }
}