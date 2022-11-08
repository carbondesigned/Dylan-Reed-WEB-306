<?php

namespace App\Models;

class Category
{
    protected static string $table_name = 'categories';
    protected int $id = 0;
    protected string $cat;

    public function __construct(string $cat)
    {
        $this->cat = $cat;
    }
}