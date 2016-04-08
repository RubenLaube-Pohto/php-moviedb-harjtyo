<?php
require_once 'idbconn.php';
require_once 'movie.php';
require_once 'person.php';

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
        $sql = "SELECT * FROM movie WHERE id='$movie_id'";
        $stmt = $this->db->query($sql);
        $movie = NULL;
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $movie = new Movie();
            $movie->id = $row['id'];
            $movie->title = $row['title'];
            $movie->year = $row['year'];
            $movie->duration = $row['duration'];
            $movie->isan = $row['isan'];
        }
        return $movie;
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

    public function getPeople($person_ids=NULL) {
        if (is_null($person_ids)) {
            $sql = "SELECT person.id, person.firstname, person.lastname, ".
                       "person.birthday ".
                   "FROM person";
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $person = new Person();
                $person->id = $row['id'];
                $person->firstname = $row['firstname'];
                $person->lastname = $row['lastname'];
                $person->birthday = $row['birthday'];
                $people[] = $person;
            }
        }
        return $people;
    }

    public function addMovie($movie) {
        $sql = "INSERT INTO movie (title, duration, isan, year) ".
               "VALUE (:title, :duration, :isan, :year)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $movie->title, PDO::PARAM_STR, 100);
        $stmt->bindParam(':year', $movie->year, PDO::PARAM_STR, 4);
        if ($movie->duration)
            $stmt->bindParam(':duration', $movie->duration, PDO::PARAM_INT);
        else
            $stmt->bindValue(':duration', NULL, PDO::PARAM_NULL);
        if ($movie->isan)
            $stmt->bindParam(':isan', $movie->isan, PDO::PARAM_STR, 38);
        else
            $stmt->bindValue(':isan', NULL, PDO::PARAM_NULL);
        $stmt->execute();
    }

    public function addPerson($person) {

    }

    public function updateMovie($movie) {
        $sql = "UPDATE movie ".
               "SET ".
                   "title=:title, ".
                   "year=:year, ".
                   "isan=:isan, ".
                   "duration=:duration ".
               "WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $movie->title, PDO::PARAM_STR, 100);
        $stmt->bindParam(':year', $movie->year, PDO::PARAM_STR, 4);
        if ($movie->duration)
            $stmt->bindParam(':duration', $movie->duration, PDO::PARAM_INT);
        else
            $stmt->bindValue(':duration', NULL, PDO::PARAM_NULL);
        if ($movie->isan)
            $stmt->bindParam(':isan', $movie->isan, PDO::PARAM_STR, 38);
        else
            $stmt->bindValue(':isan', NULL, PDO::PARAM_NULL);
        $stmt->bindParam(':id', $movie->id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updatePerson($person) {

    }

    public function deleteMovie($movie_id) {
        $sql = "DELETE FROM movie WHERE id='$movie_id'";
        $this->db->exec($sql);
        // TODO: Remove links from many to many tables
    }

    public function deletePerson($person_id) {

    }
}