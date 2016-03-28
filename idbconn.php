<?php
interface iDatabaseConnection {
	public function getMovie($movie_id);
	public function getPerson($person_id);
	public function getMovies($movie_ids);
	public function getPeople($people_ids);
	public function addMovie($movie);
	public function addPerson($person);
	public function updateMovie($movie);
	public function updatePerson($person);
	public function deleteMovie($movie_id);
	public function deletePerson($person_id);
}