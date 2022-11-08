<!DOCTYPE html>
<html>
<head>
    <title>Manage Entries</title>
</head>
<body>
<?php
// Set the variables for the database access:
require_once('../includes/config.php');

$dbc = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);

if(isset($_POST['insert'])) {
	$catID = trim($_POST['catID']);
	$subject = trim($_POST['subject']);
	$body = trim($_POST['body']);

	$query = "INSERT into `entries` values ('0', :catID, NOW(), :subject, :body)";
	$statement = $dbc->prepare($query);
	$statement->execute(compact("catID", "subject", "body"));

} elseif(isset($_POST['delete'])) {
	$id = trim($_POST['id']);

	$query = "DELETE FROM `entries` WHERE id = :id";
	$statement = $dbc->prepare($query);
	$statement->execute(compact("id"));

}

?>

<h2 style="text-align: center">Manage Entries</h2>
<table border="1" width="75%" cellspacing="2" cellpadding="2" align="center">
    <tr>
        <th>ID (auto_increment)</th>
        <th>Cat ID</th>
        <th>Date</th>
        <th>Subject</th>
        <th>Body</th>
        <th>Delete?</th>
    </tr>

	<?php
	$query = "SELECT * from `entries` ORDER BY id";
	$entries = $dbc->query($query)->fetchAll(PDO::FETCH_ASSOC);

	foreach($entries as $row) {
		?>
        <tr align="center" valign="top">
            <td align="center" valign="top"><?php echo $row['id'] ?></td>
            <td align="center" valign="top"><?php echo $row['cat_id'] ?></td>
            <td align="center" valign="top"><?php echo $row['date'] ?></td>
            <td align="center" valign="top"><?php echo $row['subject'] ?></td>
            <td align="center" valign="top"><?php echo $row['body'] ?></td>
            <td align="center" valign="top">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <input type='hidden' name="id" value="<?php echo $row['id'] ?>">
                    <input type="submit" name="delete" value="X">
                </form>
            </td>

        </tr>
		<?php
	}
	?>
</table>

<h2>Insert a new comment:</h2>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    Category Id:<input type="text" name="catID" size="1"><br>
    Subject:<input type="text" name="subject" size="30"><br>
    Body:<input type="text" name="body" size="50"><br>
    <input type="submit" name="insert" value="Insert">
</form>

<?php
$dbc = null;
?>
</body>
</html>