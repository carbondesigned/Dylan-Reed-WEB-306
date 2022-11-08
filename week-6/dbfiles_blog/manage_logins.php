<!DOCTYPE html>
<html>
<head>
    <title>Manage Logins</title>
</head>
<body>
<?php
// Set the variables for the database access:
require_once('../includes/config.php');

$dbc = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);

if(isset($_POST['insert'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$enc_pass = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

	$query = "INSERT into `logins` values ('0', :username, :enc_pass)";
	$statement = $dbc->prepare($query);
	$statement->execute(compact("username", "enc_pass"));

} elseif(isset($_POST['delete'])) {
	$id = trim($_POST['id']);

	$query = "DELETE FROM `logins` WHERE id = :id";
	$statement = $dbc->prepare($query);
	$statement->execute(compact("id"));

}

?>

<h2 style="text-align: center">Manage Logins</h2>
<table border="1" width="75%" cellspacing="2" cellpadding="2" align="center">
    <tr>
        <th>ID (auto_increment)</th>
        <th>Username</th>
        <th>Password</th>
        <th>Delete?</th>
    </tr>

	<?php
	$query = "SELECT * from `logins`  ORDER BY id";
	$logins = $dbc->query($query)->fetchAll(PDO::FETCH_ASSOC);

	foreach($logins as $row) {
		?>
        <tr align="center" valign="top">
            <td align="center" valign="top"><?php echo $row['id'] ?></td>
            <td align="center" valign="top"><?php echo $row['username'] ?></td>
            <td align="center" valign="top"><?php echo $row['password'] ?></td>
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

<h2>Insert a new user:</h2>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    Username:<input type="text" name="username" size="10"><br>
    Password:<input type="text" name="password" size="10"><br>
    <input type="submit" name="insert" value="Insert">
</form>

<?php
$dbc = null;
?>
</body>
</html>