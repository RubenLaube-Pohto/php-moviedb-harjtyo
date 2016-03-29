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
		$this->title = "";
		$this->duration = 0;
		$this->isan = "";
		$this->year = "";
		$this->companies = array();
		$this->genres = array();
		$this->people = array();
	}
}