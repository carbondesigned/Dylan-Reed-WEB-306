<?php

class Movie extends Media
{
    function __construct($id, $title, $productionCompany, $releaseYear, $director)
    {
        $this->id = $id;
        $this->title = $title;
        $this->productionCompany = $productionCompany;
        $this->releaseYear = $releaseYear;
        $this->director = $director;
    }

    public function create($dbc)
    {
        $query = "INSERT INTO movies (title, year_released, production_company, director) VALUES ('$this->title', '$this->releaseYear', '$this->productionCompany', '$this->director')";
        $dbc->sqlQuery($query);
    }
    static function all($dbc)
    {
        $query = "SELECT * FROM movies";
        $result = $dbc->fetchArray($query);
        return $result;
    }
    static function delete($dbc, $title)
    {
        $query = "DELETE FROM movies WHERE title = '$title'";
        $result = $dbc->sqlQuery($query);
        return $result;
    }
    static function getByTitle($dbc, $title)
    {
        $query = "SELECT * FROM movies WHERE title = '$title'";
        $result = $dbc->fetchRecord($query);
        $newObj = new self($result['id'], $result['title'], $result['production_company'], $result['year_released'], $result['director']);
        return $newObj;
    }
    public function update($dbc)
    {
        $query = "UPDATE movies SET title = '$this->title', year_released = '$this->releaseYear', production_company = '$this->productionCompany', director = '$this->director' WHERE id = '$this->id'";
        $result = $dbc->sqlQuery($query);
        return $result;
    }
}
