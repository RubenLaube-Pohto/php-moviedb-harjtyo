<?php
/**
 * Basic interface for a movie database.
 *
 * Using Slim framework, Plates template engine, MySQL database.
 * Commenting tries to follow the PHPDoc standard.
 *
 * @author Ruben Laube-Pohto
 *
 * @license MIT
 */

/**
 * Include the required packages.
 */
require 'vendor/autoload.php';

/** @var Slim $app The web app.*/
$app = new \Slim\Slim();

// Enable debug-mode.
$app->config('debug', true);

// Use Plates when rendering
$app->view(
    new Slim\Views\Plates(function (League\Plates\Engine $engine) use ($app) {
        $engine->loadExtension(new League\Plates\Extension\URI($app->request()->getPathInfo()));
        $engine->loadExtension(new Slim\Views\PlatesExtension);
    })
);
// getEngine() returns the Plates engine
// Set navbar links
$app->view->getEngine()->addData(
    array('link_movies' => $app->request->getRootUri().'/movies',
          'link_new_movie' => $app->request->getRootUri().'/movies/new',
          'link_people' => $app->request->getRootUri().'/people'),
    'navbar'
);

require_once 'mysqlconn.php';
require_once 'movie.php';
require_once 'person.php';

/**
 * Main page.
 *
 * Not implemented.
 */
$app->get('/', function() use ($app) {
    // TODO: Add landing page
    $app->redirect($app->urlFor('movies'));
});

/**
 * List all movies.
 */
$app->get('/movies', function() use ($app) {
    $conn = new MySQLConnection();
    $movies = $conn->getMovies();
    $app->render('movies', array('movies' => $movies));
})->name('movies');

/**
 * Display form for adding new movie.
 *
 * New movie -page on GET-method.
 */
$app->get('/movies/new', function() use ($app) {
    $app->render('add_movie');
});

/**
 * Add new movie to database.
 *
 * New movie -page on POST-method.
 */
$app->post('/movies/new', function() use ($app) {
    $post = $app->request->post();
    $conn = new MySQLConnection();
    $movie = new Movie();
    $movie->title = $post['title'];
    $movie->year = $post['year'];
    if ($post['duration'])
        $movie->duration = (int)$post['duration'];
    if ($post['isan'])
        $movie->isan = $post['isan'];
    $conn->addMovie($movie);
    $app->redirect($app->urlFor('movies'));
});

/**
 * Display the movie with the ID and provide editing options.
 *
 * GET: Display page.
 * PUT: Update movie's information in the database.
 * DELETE : Delete the movie from the database.
 */
$app->map('/movies/:id', function($id) use ($app) {
    $conn = new MySQLConnection();

    if ($app->request->isPut()) {
        $put = $app->request->put();
        $movie = new Movie();
        $movie->id = (int)$id;
        $movie->title = $put['title'];
        $movie->year = $put['year'];
        if ($put['duration'])
            $movie->duration = (int)$put['duration'];
        if ($put['isan'])
            $movie->isan = $put['isan'];
        $conn->updateMovie($movie);
    }
    else if ($app->request->isDelete()) {
        $conn->deleteMovie($id);
        $app->redirect($app->urlFor('movies'));
    }

    $movie = $conn->getMovie($id);
    $app->render('edit_movie', array('movie' => $movie));
})->via('GET', 'PUT', 'DELETE');

/**
 * List all people.
 */
$app->get('/people', function() use ($app) {
    $conn = new MySQLConnection();
    $people = $conn->getPeople();
    $app->render('people', array('people' => $people));
})->name('people');

/**
 * Display the person with the ID and provide editing options.
 *
 * GET: Display page.
 * PUT: Update person's information in the database.
 * DELETE : Delete the person from the database.
 */
$app->map('/people/:id', function($id) use ($app) {
    $conn = new MySQLConnection();
    if ($app->request->isPut()) {
        $put = $app->request->put();
	$person = new Person();
	$person->id = (int)$id;
	$person->firstname = $put['firstname'];
	$person->lastname = $put['lastname'];
	$person->birthday = $put['birthday'];
	$conn->updatePerson($person);
    }
    else if ($app->request->isDelete()) {
        $conn->deletePerson($id);
	$app->redirect($app->urlFor('people'));
    }
    $person = $conn->getPerson($id);
    $app->render('edit_person', array('person' => $person));
})->via('GET', 'PUT', 'DELETE');

/**
 * Run the application.
 */
$app->run();
