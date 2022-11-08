<?php

namespace App\Models;

class Image
{
    protected static string $table_name = 'images';
    protected int $id = 0;
    protected int $item_id;
    protected string $name;

    public function __construct(int $item_id, string $name)
    {
        $this->item_id = $item_id;
        $this->name = $name;
    }
}