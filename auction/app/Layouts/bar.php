<?php
    use App\Exceptions\ClassException;
    use App\Lib\Logger;
    use App\Models\Category;

try {
    $catObjs = Category::getAll('cat');
} catch (ClassException $e) {
    Logger::getLogger()->critical("Could not get Category Objects", ['exception' => $e]);
    echo "Could not get Category Objects";
    die();
}
?>

<h2>Categories</h2>
<ul>
    <li>
        <a href="index.php">View All</a>
        <?php
        foreach ($catObjs as $catObj) {
            echo "<li><a href='index.php?cat=" . $catObj->getId() . "'>" . $catObj->getName() . "</a></li>";
        }
        ?>
    </li>
</ul>
