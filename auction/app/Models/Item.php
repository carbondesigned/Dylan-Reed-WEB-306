<?php

namespace App\Models;

use App\Lib\Model;

class Item extends Model
{
    protected static string $table_name = 'items';
    protected $id = 0;
    protected $name;
    protected $description;
    protected $cat_id;
    protected $user_id;
    protected $notified = 0;
    protected $price;
    protected $date;
    protected $imageObjs;
    protected $bidObjs;

    public function __construct($user_id, $cat_id, $name, $price, $description, $date)
    {
        $this->name = $name;
        $this->description = $description;
        $this->cat_id = $cat_id;
        $this->user_id = $user_id;
        $this->price = $price;
        $this->date = $date;
    }

    public function getImages(): array {
        $this->imageObjs = Image::find('item_id', $this->id);
        return $this->imageObjs;
    }
    public function getBids(): array {
        $this->bidObjs = Bid::find('item_id', $this->id);
        return $this->bidObjs;
    }

}