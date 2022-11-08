<?php

class Movie
{
    public $id;
    public $title;
    public $productionCompany;
    public $releaseYear;
    public $director;
    public $amount = 10;

    function __construct($id, $title, $productionCompany, $releaseYear, $director)
    {
        $this->id = $id;
        $this->title = $title;
        $this->productionCompany = $productionCompany;
        $this->releaseYear = $releaseYear;
        $this->director = $director;
    }

    function create($dbc)
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
}
