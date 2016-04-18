<?php
/**
 * Movie class
 */
class Movie {
    /** @var integer $id Movie ID. */
    public $id;
    /** @var string $title Title of the movie. */
    public $title;
    /** @var integer $duration Duration of the movie in seconds. */
    public $duration;
    /** @var string $isan ISAN of the movie. */
    public $isan;
    /** @var string $year Original publishing year of the movie. */
    public $year;
    /** @var integer[] $companies IDs of the related companies. */
    public $companies;
    /** @var integer[] $genres IDs of the related genres */
    public $genres;
    /** @var integer[] $people IDs of related people. */
    public $people;

    /**
     * Default constructor.
     */
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
