<?php

namespace App\Models;

use App\Lib\Model;

class Category extends Model
{
    protected static string $table_name = 'categories';
    protected int $id = 0;
    protected string $cat;

    public function __construct(string $cat)
    {
        $this->cat = $cat;
    }
}