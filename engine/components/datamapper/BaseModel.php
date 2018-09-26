<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 25.09.2018
 * Time: 11:24
 */

namespace engine\components\datamapper;


abstract class BaseModel
{

    protected $safeAttributes;

    public function __construct(array $attributes)
    {
        foreach ($attributes as $name => $value){
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        if (empty($this->$name)){
            throw new \Error('variable ' . $name . ' not defined');
        }
        return $this->$name;
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->safeAttributes)){
            $this->$name = $value;
        }
        else {
            throw new \Error('attribute ' . $name . ' is read only');
        }

    }

    public function setSafeAttributes()
    {

    }


}