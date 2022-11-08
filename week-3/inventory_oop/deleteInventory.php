<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>

<body>
    <?php
    require_once('includes/bootstrap.php');

    $title = trim($_POST['Title']);
    $invTitle = Movie::getByTitle($dbc, $title);
    if ($invTitle) {
        $result = Movie::delete($dbc, $title);
        if ($result) {
            echo "Movie deleted successfully";
        } else {
            echo "Error deleting movie";
        }
    } else {
        $invTitle = Music::find($dbc, $title);
        if ($invTitle) {
            $result = Music::delete($dbc, $title);
            if ($result) {
                echo "Music deleted successfully";
            } else {
                echo "Error deleting music";
            }
        }
    }
    ?>
</body>

</html>