<?php

class Media
{
    protected $id;
    protected $title;
    protected $productionCompany;
    protected $releaseYear;

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setDirector($director)
    {
        $this->director = $director;
    }
    public function getDirector()
    {
        return $this->director;
    }
    public function setReleaseYear($releaseYear)
    {
        $this->releaseYear = $releaseYear;
    }
    public function getReleaseYear()
    {
        return $this->releaseYear;
    }
    public function setProductionCompany($productionCompany)
    {
        $this->productionCompany = $productionCompany;
    }
    public function getProductionCompany()
    {
        return $this->productionCompany;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
}
