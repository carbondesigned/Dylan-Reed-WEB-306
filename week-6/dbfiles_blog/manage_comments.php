<!DOCTYPE html>
<html>
<head>
    <title>Manage Comments</title>
</head>
<body>
<?php
// Set the variables for the database access:
require_once('../includes/config.php');

$dbc = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);

if(isset($_POST['insert'])) {
	$blogID = trim($_POST['blogID']);
	$name = trim($_POST['name']);
	$comment = trim($_POST['comment']);

	$query = "INSERT into `comments` values ('0', :blogID, NOW(), :name, :comment)";
	$statement = $dbc->prepare($query);
	$statement->execute(compact("blogID", "name", "comment"));

} elseif(isset($_POST['delete'])) {
	$id = trim($_POST['id']);

	$query = "DELETE FROM `comments` WHERE id = :id";
	$statement = $dbc->prepare($query);
	$statement->execute(compact("id"));


}

?>

<h2 style="text-align: center">Manage Comments</h2>
<table border="1" width="75%" cellspacing="2" cellpadding="2" align="center">
    <tr>
        <th>ID (auto_increment)</th>
        <th>Blog ID</th>
        <th>Date</th>
        <th>Name</th>
        <th>Comment</th>
        <th>Delete?</th>
    </tr>

	<?php
	$query = "SELECT * from `comments` ORDER BY id";
	$comments = $dbc->query($query)->fetchAll(PDO::FETCH_ASSOC);

	foreach($comments as $row) {
		?>
        <tr align="center" valign="top">
            <td align="center" valign="top"><?php echo $row['id'] ?></td>
            <td align="center" valign="top"><?php echo $row['blog_id'] ?></td>
            <td align="center" valign="top"><?php echo $row['date'] ?></td>
            <td align="center" valign="top"><?php echo $row['name'] ?></td>
            <td align="center" valign="top"><?php echo $row['comment'] ?></td>
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
    Blog ID:<input type="text" name="blogID" size="1"><br>
    Name:<input type="text" name="name" size="30"><br>
    Comment:<input type="text" name="comment" size="50"><br>
    <input type="submit" name="insert" value="Insert">
</form>

<?php
$dbc = null;
?>
</body>
</html>