<?php
require_once('includes/bootstrap.php');
require_once("header.php");

if (!$session->isLoggedIn()) {
	header("Location: index1.php");
}

if (!$session->getUser() || !is_numeric($_GET['id'])) {
	header("Location: index1.php");
}

$validId = $_GET['id'];
$entry = Entry::find("SELECT * FROM `entries` WHERE od = :validId LIMIT 1", [':validId' => $validId]);
$entry = array_shift($entry);

if (isset($_POST['submit'])) {
	$_POST['cat'] = addslashes($_POST['cat']);
	$_POST['subject'] = addslashes($_POST['subject']);
	$_POST['body'] = addslashes($_POST['body']);

	$entry->setCat($_POST['cat']);
	$entry->setSubject($_POST['subject']);
	$entry->setBody($_POST['body']);
	$entry->update();

	header("Location: index1.php");
} else {
?>

	<h1>Update Entry</h1>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?id=" . $validId; ?>" method="post">
		<table>
			<tr>
				<td>Category</td>
				<td>
					<select name="cat">
						<?php
						$categories = Category::all();
						foreach ($categories as $category) {
							$selected = ($category->getId() == $entry->getCat()) ? "selected" : "";
							echo "<option value=\"{$category->getId()}\" $selected>{$category->getName()}</option>";
						}
						?>
					</select>
				</td>
			</tr>

			<tr>
				<td>Subject</td>
				<td><input type="text" name="subject" value="<?php echo $entry->getSubject(); ?>" /></td>
			</tr>

			<tr>
				<td>Body</td>
				<td><textarea name="body" rows="10" cols="50"><?php echo $entry->getBody(); ?></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="Update Entry" /></td>
			</tr>
		</table>
	</form>
<?php
}
require_once('footer.php');
?>