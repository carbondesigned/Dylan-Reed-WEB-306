<?php
require_once('includes/bootstrap.php');
require_once('header.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	$validId = 0;
} else {
	$validId = $_GET['id'];
}

$categories = Category::all();

if (count($categories) == 0) {
	echo "You must create a category before you can create an entry.";
} else {
	foreach ($categories as $category) {
		if ($category->getId() == $validId) {
			echo "<span style='font-weight: bold>
				{$category->getCat()}</span>
			";
			echo "<ul>";

			$entries = Entry::find("SELECT * FROM `entries` WHERE cat_id = :validId ORDER BY date DESC", [':validId' => $validId]);

			if (count($entries) == 0) {
				echo "<li>No entries found.</li>";
			} else {
				foreach ($entries as $entry) {
					echo "<li>" . date(
						"D js F Y g.iA",
						strtotime(($entry->getDate()))
					) . " - <a href='viewentry.php?id=" . $entry->getId() . "'>" . $entry->getSubject() . "</a></li>";
				}
			}
			echo "</ul>";
		} else {
			echo "<a href='viewcat.php?id=" . $category->getId() . "'>" . $category->getCat() . "</a><br>";
		}
	}
}
require_once("footer.php");
