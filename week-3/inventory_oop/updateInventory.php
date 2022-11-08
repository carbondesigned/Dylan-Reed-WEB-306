<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>

<body>
    <?php
    require_once('includes/bootstrap.php');

    $title = trim($_POST['Title']);
    $director = trim($_POST['Director']);

    $movie = Movie::getByTitle($dbc, $title);

    if ($movie) {
        $movie->setDirector($director);

        $result = $movie->update($dbc);

        if ($result) {
            echo "Movie updated successfully";
        } else {
            echo "Error updating movie";
        }
    } else {
        $music = Music::find($dbc, $title);
        if ($music) {
            $music->setDirector($director);

            $result = $music->update($dbc);

            if ($result) {
                echo "Music updated successfully";
            } else {
                echo "Error updating music";
            }
        }
    }
    ?>
</body>

</html>