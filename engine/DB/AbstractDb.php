<?php
/**
 * User: IGrock
 * Date: 28.03.2018
 * Time: 19:37
 */

namespace engine\DB;

use engine\components\Singleton;

abstract class AbstractDb
{
    use Singleton;

    protected $connection;

    abstract public function close();

    abstract public function connect();

    abstract public function select($sql);

    abstract public function insert($table, $cols, array $values);

    abstract public function delete($table, $where = null);

    abstract public function update($table, $rows, $where);

}