<!DOCTYPE html>
<html>
<head>
    <title>Create Blog tables</title>
</head>
<body>
<?php
// Set the variables for the database access:
require_once('../includes/config.php');
echo "<h1>Table Refresh Script</h1>";

if(isset($_POST['refresh'])) {
	$dbc = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
	$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$queries[] = "DROP TABLE IF EXISTS `categories`;";
	$queries[] = "DROP TABLE IF EXISTS `comments`;";
	$queries[] = "DROP TABLE IF EXISTS `entries`;";
	$queries[] = "DROP TABLE IF EXISTS `logins`;";

	$queries[] = "CREATE TABLE `categories` (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  cat VARCHAR(20)
);";

	$queries[] = "CREATE TABLE `comments` (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  blog_id INT,
  date DATETIME,
  name VARCHAR(50),
  comment TEXT
);";

	$queries[] = "CREATE TABLE `entries` (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  cat_id INT,
  date DATETIME,
  subject VARCHAR(100),
  body TEXT
);";

	$queries[] = "CREATE TABLE `logins` (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(60)
);";

	try {
		foreach($queries as $query) {
			$dbc->query($query);
		}
	} catch(PDOException $exception) {
		echo "Error: " . $exception->getMessage() . "<br>";
	}

	echo "Tables successfully refreshed";

	$dbc = null;
} else {
	?>
    <p>Would you like to refresh the blog tables (<i>categories</i>, <i>comments</i>, <i>entries</i>, <i>logins</i>)?<p>
    <p><b>Warning: existing tables and records will be destroyed!</b></p>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="submit" name="refresh" value="Yes">
    </form>
	<?php
}
?>
</body>
</html>