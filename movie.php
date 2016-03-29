<?php
class Movie {
    public $id;
    public $title;
    public $duration;
    public $isan;
    public $year;
    public $companies;
    public $genres;
    public $people;

    public function Movie() {
        $this->id = NULL;
        $this->title = NULL;
        $this->duration = NULL;
        $this->isan = NULL;
        $this->year = NULL;
        $this->companies = array();
        $this->genres = array();
        $this->people = array();
    }
}