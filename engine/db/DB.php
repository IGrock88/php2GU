<?php


namespace engine\db;


use phpDocumentor\Reflection\Types\Boolean;

class DB extends AbstractDb
{

    public function close()
    {
        mysqli_close($this->connection);
    }

    public function connect()
    {
        return $this->connection = mysqli_connect(HOST, USER, PASS, DB);
    }

    public function select($sql)
    {
        if ($result = mysqli_query($this->connection, $sql)) {
            $array_result = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $array_result[] = $row;
            }
            if (!empty($array_result)){
                return $array_result;
            }
            return false;
        } else {
            return false;
        }
    }


    public function insert($table, $cols, array $values): bool
    {
        $sql = 'insert into ' . $table;
        if ($cols != null) {
            $sql .= ' (' . $cols . ')';
        }
        for ($i = 0; $i < count($values); $i++) {
            if (is_string($values[$i]))
                $values[$i] = '"' . $values[$i] . '"';
        }
        $values = implode(',', $values);
        $sql .= ' values (' . $values . ')';

        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            return false;
        }

    }

    public function delete($table, $where = null)
    {
        $sql = 'DELETE FROM ' . $table;
        if ($where != null) {
            $sql = $sql . ' WHERE ' . $where;
        }
        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($table, $rows, $where)
    {
        $sql = 'UPDATE ' . $table . ' SET ';
        $keys = array_keys($rows);
        for ($i = 0; $i < count($rows); $i++) {
            if (is_string($rows[$keys[$i]])) {
                $sql .= $keys[$i] . '="' . $rows[$keys[$i]] . '"';
            } else {
                $sql .= $keys[$i] . '=' . $rows[$keys[$i]];
            }
            if ($i != count($rows) - 1) {
                $sql .= ',';
            }
        }

        $sql .= ' WHERE ' . $where;
        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            return false;
        }
    }


}


