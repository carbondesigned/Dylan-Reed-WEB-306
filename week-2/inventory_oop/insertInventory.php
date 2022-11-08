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
    require_once("includes/bootstrap.php");

    $title = trim($_POST["Title"]);
    $productionCompany = trim($_POST["ProductionCompany"]);
    $releaseYear = trim($_POST["ReleaseYear"]);
    $director = trim($_POST["Director"]);

    $movie = new Movie(0, $title, $productionCompany, $releaseYear, $director);
    $result = $movie->create($dbc);

    if ($result) {
        echo "Movie added successfully";
    } else {
        echo "Error: " . $result;
    }
    ?>
</body>

</html>