<?php

namespace App\Models;

use App\Lib\Model;

class Image extends Model
{
    protected static string $table_name = 'images';
    protected int $id = 0;
    protected $item_id;
    protected $name;
    public static $errorArray = [
        'empty' => 'Please select an image to upload!',
        'nophoto' => 'Please select an image to upload!',
        'invalid' => 'Invalid image file!',
        'photoprob' => 'There was a problem uploading your image!',
        'large' => 'Image file is too large!',
    ];

    public function __construct($item_id, $name)
    {
        $this->item_id = $item_id;
        $this->name = $name;
    }
}