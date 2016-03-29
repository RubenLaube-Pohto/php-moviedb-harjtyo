<?php
require_once 'idbconn.php';
require_once 'movie.php';

class MySQLConnection implements iDatabaseConnection {
	
	private $db;
	
	public function MySQLConnection() {
		$this->db = $this->connect();
	}
	
	private function connect() {
		require_once 'dbconf.php';
		$db = new PDO($settings['CONNECTION'],
					  $settings['USERNAME'],
					  $settings['PASSWORD']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		return $db;
	}
	
	public function getMovie($movie_id) {
		
	}
	
	public function getPerson($person_id) {
		
	}
	
	public function getMovies($movie_ids=NULL) {
		if (is_null($movie_ids)) {
			$sql = "SELECT id, title, year FROM movie";
			$stmt = $this->db->query($sql);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$movie = new Movie();
				$movie->id = $row['id'];
				$movie->title = $row['title'];
				$movie->year = $row['year'];
				$movies[] = $movie;
			}
		}
		return $movies;
	}
	
	public function getPeople($people_ids) {
		
	}
	
	public function addMovie($movie) {
		
	}
	
	public function addPerson($person) {
		
	}
	
	public function updateMovie($movie) {
		
	}
	
	public function updatePerson($person) {
		
	}
	
	public function deleteMovie($movie_id) {
		
	}
	
	public function deletePerson($person_id) {
		
	}
}