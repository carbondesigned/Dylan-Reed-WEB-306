<?php

namespace App\Models;

use App\Lib\Model;

class Bid extends Model
{
    protected static string $table_name = 'bids';
    protected int $id = 0;
    protected int $item_id;
    protected int $user_id;
    protected float $amount;

    public function __construct(int $item_id, int $user_id, float $amount)
    {
        $this->item_id = $item_id;
        $this->user_id = $user_id;
        $this->amount = $amount;
    }
}