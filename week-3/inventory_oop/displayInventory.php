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
    ?>
    <h2>Display Movies</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Production Company</th>
            <th>Release Year</th>
            <th>Director</th>
        </tr>
        <?php
        $movies = Movie::all($dbc);
        foreach ($movies as $movie) {
            echo "<tr>";
            echo "<td>" . $movie["title"] . "</td>";
            echo "<td>" . $movie["production_company"] . "</td>";
            echo "<td>" . $movie["year_released"] . "</td>";
            echo "<td>" . $movie["director"] . "</td>";
            echo "</tr>";
        }
        ?>
        <h2>Display Music</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Album Title</th>
                <th>Production Company</th>
                <th>Year Released</th>
            </tr>
            <?php
            $music = Music::all($dbc);
            if ($music) {
                foreach ($music as $song) {
                    echo "<tr>";
                    echo "<td>" . $song["title"] . "</td>";
                    echo "<td>" . $song["album"] . "</td>";
                    echo "<td>" . $song["production_company"] . "</td>";
                    echo "<td>" . $song["year_released"] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
</body>

</html>