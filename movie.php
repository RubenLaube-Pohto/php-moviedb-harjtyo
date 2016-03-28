<?php
class Movie {
	public $id;
	public $title;
	public $year;
	
	public function Movie($id, $title, $year) {
		$this->id = $id;
		$this->title = $title;
		$this->year = $year;
	}
}