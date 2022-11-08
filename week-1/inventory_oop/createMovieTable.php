<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once('includes/bootstrap.php');

        $dbc = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $query = "CREATE TABLE IF NOT EXISTS movies (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            year_released INT UNSIGNED NOT NULL,
            production_company VARCHAR(255) NOT NULL,
            director VARCHAR(255) NOT NULL,
            PRIMARY KEY (id)
        )";

        $result = $dbc->query($query);


        if ($result) {
            echo "Table created successfully";
        } else {
            echo "Error creating table: " . $dbc->errorInfo()[2];
        }
    ?>
</body>
</html>