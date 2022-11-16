<?php

namespace App\Models;

use App\Lib\Model;

class Image extends Model
{
    protected static string $table_name = 'images';
    protected int $id = 0;
    protected $item_id;
    protected $name;

    public function __construct($item_id, $name)
    {
        $this->item_id = $item_id;
        $this->name = $name;
    }
}