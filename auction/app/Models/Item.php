<?php

namespace App\Models;

class Item
{
    protected static string $table_name = 'items';
    protected int $id = 0;
    protected string $name;
    protected string $description;
    protected int $cat_id;
    protected int $user_id;
    protected int $notified = 0;
    protected float $price;
    protected string $date;

    public function __construct(string $name, string $description, int $cat_id, int $user_id, float $price, string $date)
    {
        $this->name = $name;
        $this->description = $description;
        $this->cat_id = $cat_id;
        $this->user_id = $user_id;
        $this->price = $price;
        $this->date = $date;
    }

}