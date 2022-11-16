<?php

use App\Models\Item;
require_once __DIR__ . "/../app/bootstrap.php";

if (isset($_GET['id'])) {
    $validid = pf_validate_number($_GET['id'], "value", CONFIG_URL);
} else {
    $validid = 0;
}

require_once __DIR__ . "/../app/Layouts/header.php";

if ($validid == 0) {
    $items = Item::find("date > NOW()");
} else {
    $items = Item::find("date > NOW() AND cat_id = $validid");
}

if (!$items) {
    echo "<tr><td colspan='7'>No items found</td></tr>";
} else {
    foreach ($items as $item) {
        echo "<tr>";
        // ADD THE CODE TO LOAD THE IMAGES into $item by getting the ./imgs directory and the name of the image
//        echo "<td><img src='" . $item->getImages()[0]->get('name'). "' width='100' height='100'></td>";

        echo "<td><img src='./imgs/" . $item->getImages()[0]->get('name'). "' width='100' height='100'></td>";

        if (!$item->get('imageObjs')) {
            echo "<td>No image</td>";
        } else {
            $img = $item->get('imageObjs');
            $firstImg = array_shift($img);
                echo "<td>";
                echo "<a href='itemdetails.php?id={$item->get('id')}'>{$item->get('name')}</a>";
            echo "</td>";
            echo "<td>";
            $item->getBids();
            if (!$item->get('bidObjs')) {
                echo "0";
            } else {
                echo count($item->get('bidObjs'));
            }
            echo "</td>";
            echo "<td>" . CONFIG_CURRENCY;

            if (!count($item->get('bidObjs'))) {
                echo sprintf("%.2f", $item->get('price'));
            } else {
                $itemBids = $item->get('bidObjs');
                $highestBid = array_shift($itemBids);
                echo sprintf("%.2f", $highestBid->get('amount'));
            }
            echo "</td>";
        }
    }
}
 require_once __DIR__ . "/../app/Layouts/footer.php";
?>
