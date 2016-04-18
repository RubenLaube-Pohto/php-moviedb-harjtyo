<?php
require_once 'idbconn.php';
require_once 'movie.php';
require_once 'person.php';

/**
 * Connection to a MySQL database.
 *
 * A database connection that implements iDatabaseConnection-interface.
 */
class MySQLConnection implements iDatabaseConnection {

    /** @var PDO $db Connection instance. */
    private $db;

    /**
     * Default constructor.
     *
     * Initializes database connection.
     */
    public function MySQLConnection() {
        $this->db = $this->connect();
    }

    /**
     * Initialize connection to the database.
     *
     * @return PDO Database connection.
     */
    private function connect() {
        require_once 'dbconf.php';
        $db = new PDO($settings['CONNECTION'],
                      $settings['USERNAME'],
                      $settings['PASSWORD']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $db;
    }

    /**
     * Get movie by id.
     *
     * @param integer $movie_id ID of the Movie to get.
     *
     * @return Movie|null The Movie if found.
     */
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

    /**
     * Get person by id.
     *
     * @param integer $person_id ID of the Person to get.
     *
     * @return Person|null The Person if found.
     */
    public function getPerson($person_id) {
        $sql = "SELECT * FROM person WHERE id='$person_id'";
        $stmt = $this->db->query($sql);
	$person = NULL;
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $person = new Person();
	    $person->id = $row['id'];
	    $person->firstname = $row['firstname'];
	    $person->lastname = $row['lastname'];
	    $person->birthday = $row['birthday'];
	    $person->profession = $this->getProfession($row['profession_id']);
        }
	return $person;
    }

    /**
     * Get multiple Movies.
     *
     * Get the movies specified by $movie_ids or if null get all movies
     * in the database.
     *
     * @param integer[]|null $movie_ids IDs of the movies to get.
     *
     * @return Movie[] Found movies.
     */
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

    /**
     * Get multiple people.
     *
     * Get the people specified by $person_ids or if null get all people
     * in the database.
     *
     * @param integer[]|null $person_ids IDs of the people to get.
     *
     * @return Person[] Found people.
     */
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

    /**
     * Add a new movie to the database.
     *
     * @param Movie $movie The movie to add.
     */
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

    /**
     * Add a new person to the database.
     *
     * Not implemented.
     *
     * @param Person $person The person to add.
     */
    public function addPerson($person) {
        // TODO: Add person to databse.
    }

    /**
     * Update the information of a movie.
     *
     * @param Movie $movie Updated movie object.
     */
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

    /**
     * Update the information of a person.
     *
     * @param Person $person Updated person object.
     */
    public function updatePerson($person) {
        $sql = "UPDATE person ".
               "SET ".
                   "firstname=:firstname, ".
                   "lastname=:lastname, ".
                   "birthday=:birthday ".
               "WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':firstname', $person->firstname, PDO::PARAM_STR, 50);
        $stmt->bindParam(':lastname', $person->lastname, PDO::PARAM_STR, 100);
	$stmt->bindParam(':birthday', $person->birthday, PDO::PARAM_STR, 10);
        $stmt->bindParam(':id', $person->id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Delete the movie from the database.
     *
     * Deletes the movie and its relations.
     *
     * @param integer $movie_id ID of the movie to delete.
     */
    public function deleteMovie($movie_id) {
        $sql = "DELETE FROM movie_has_genre WHERE movie_id='$movie_id'";
        $this->db->exec($sql);
        $sql = "DELETE FROM movie_has_company WHERE movie_id='$movie_id'";
        $this->db->exec($sql);
        $sql = "DELETE FROM movie_has_person_has_role WHERE movie_id='$movie_id'";
        $this->db->exec($sql);
        $sql = "DELETE FROM movie WHERE id='$movie_id'";
        $this->db->exec($sql);
    }

    /**
     * Delete the person from the database.
     *
     * Deletes the person and its relations.
     *
     * @param integer $person_id ID of the person to delete.
     */
    public function deletePerson($person_id) {
        $sql = "DELETE FROM movie_has_person_has_role WHERE person_id='$person_id'";
	$this->db->exec($sql);
        $sql = "DELETE FROM person WHERE id='$person_id'";
	$this->db->exec($sql);
    }

    /**
     * Get a profession.
     *
     * @param integer $profession_id ID of the profession to get.
     *
     * @return string The found profession.
     */
    private function getProfession($profession_id) {
	$sql = "SELECT profession FROM profession WHERE id='$profession_id'";
	$stmt = $this->db->query($sql);
	$profession = "";
	if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $profession = $row['profession'];
	}
	return $profession;
    }
}
