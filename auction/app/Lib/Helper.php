<?php

namespace App\Lib;

trait Helper
{
    /**
     * @param string $var
     * @return false
     */
    public function get(string $var) {
        if (property_exists(get_called_class(), $var)) {
            return $this->$var;
        } else {
           return false;
        }
    }

    /**
     * @param string $var
     * @param $value
     * @return false|void
     */
    public function set(string $var, $value) {
        if (property_exists(get_called_class(), $var)) {
            $this->$var = $value;
        } else {
            return false;
        }
    }
}