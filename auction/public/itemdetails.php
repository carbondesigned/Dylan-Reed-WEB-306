<?php

use App\Exceptions\ClassException;
use App\Lib\Logger;
use App\Models\Bid;
use App\Models\Item;
use App\Models\User;

require_once __DIR__ . '/../app/bootstrap.php';

$validid = pf_validate_number($_GET['id'], 'redirect', CONFIG_URL);
try {
    $item = Item::findFirst(["id" => $validid]);
} catch (ClassException $e) {
    Logger::getLogger()->critical("invalid item: ", ['exception' => $e]);
    echo "invalid item";
    die();
}

// Load Bid & Image objects into item
// ADD CODE TO LAZY LOAD BOTH IMAGE AND BID OBJECTS
$item->getImages();
$item->getBids();

if (isset($_POST['submit'])) {
    if (is_numeric($_POST['bid']) == false) {
        header("Location: itemdetails.php?id=" . $validid . "&error=letter");
        die();
    }
}

$validbid = false;
if (count($item->get('bidObjs')) == 0) {
    $price = intval($item->get('price'));
    $postedBid = intval($_POST['bid']);

    if ($postedBid >= $price) {
        $validid = true;
    }
} else {
    $bids = $item->get('bidObjs');
    $highestBid = array_shift($bids);
    $highestBid = intval($highestBid->get('amount'));
    $postedBid = intval($_POST['bid']);
    if ($postedBid > $highestBid) {
        $validid = true;
    }
}

if ($validbid == false) {
  header("Location: itemdetails.php?id=" . $validid . "&error=lowprice#bidbox");
  die();
} else {
    $newBid = new Bid($item->get('id'), $_POST['bid'], $session->getUser()->get('id'));
    $newBid->create();
    header("Location: itemdetails.php?id=" . $validid);
    die();
}

require_once __DIR__ . '/../app/Layouts/header.php';
$nowepoch = time();
$itemepoch = strtotime($item->get('date'));
$validAuction = false;

if ($itemepoch > $nowepoch) {
    $validAuction = true;
}

echo "<h1>{$item->get('name')}</h1>";
echo "<p>{$item->get('description')}</p>";
echo "<p>";
if ($item->get('bidObjs')) {
    echo "<strong>This item has had no bids</strong> - <strong>Starting Price</strong>: " . CONFIG_CURRENCY . sprintf("%.2f", $item->get('price'));
} else {
    $bids = $item->get('bidObjs');
    $highestBid = array_shift($bids);
    echo "<strong>Highest Bid</strong>: " . CONFIG_CURRENCY . sprintf("%.2f", $highestBid->get('amount'));
}

echo " - <string>Auction Ends</strong>: " . date("D jS F Y g.iA", $itemepoch);
echo "</p>";

$imgs = $item->get('imageObjs');
$img = array_shift($imgs);

if ($item->get('imageObjs')) {
    echo "<img src='imgs/{$img->get('name')}' width='200'>";
} else {
    echo "No images";
}

echo "<p>" . nl2br($item->get('description')) . "</p>";

echo "<a name='bidbox'></a>";
echo "<h3>Bid for this item</h3>";

// check if user is logged in using the Session class
if ($session->isLoggedIn()) {
    echo "To bid, you need to log in. Login <a href='logout.php?id=" . $validid . "&ref=addbid'>here</a>";
}

if ($validAuction == true) {
    echo "Enter the bid amount into the box below.";
    echo "<p>";
    if (isset($_GET['error'])) {
        try {
            $errorMessage = Item::displayError($_GET['error']);
        } catch (ClassException $e) {
            Logger::getLogger()->errpr("invalid error: ", ['exception' => $e]);
            die();
        }
        echo $errorMessage;
    }
}
?>

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <table>
        <tr>
            <td>
                <input type="number" name="bid">
            </td>
            <td>
                <input type="submit" name="submit" id="submit" value="Bid!">
            </td>
        </tr>
    </table>
</form>

<?php
if (count($item->get('bidObjs')) > 0) {
    echo "<h2>Bid History</h2>";
    echo "<ul>";
    foreach ($item->get('bidObjs') as $bid) {
        $id = $bid->get('user_id');
        try {
            $user = User::findFirst(["id" => $id]);
        } catch (ClassException $e) {
            Logger::getLogger()->critical("invalid user: ", ['exception' => $e]);
            die();
        }
        echo "<li>{$user->get('username')} - " . CONFIG_CURRENCY . sprintf("%.2f", $bid->get('amount')) . "</li>";
    }
    echo "</ul>";
}

require_once __DIR__ . '/../app/Layouts/footer.php';

?>