<?php
// Init Slim
require 'vendor/autoload.php';
$app = new \Slim\Slim();
// define settings
$app->config('debug', true);

// Use Plates when rendering
$app->view(
    new Slim\Views\Plates(function (League\Plates\Engine $engine) use ($app) {
        $engine->loadExtension(new League\Plates\Extension\URI($app->request()->getPathInfo()));
        $engine->loadExtension(new Slim\Views\PlatesExtension);
    })
);
// getEngine() returns the Plates engine
// Set css file to use
$app->view->getEngine()->addData(
    array('maincss' => $app->request->getRootUri().'/static/main.css'),
    'template'
);
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

$app->get('/', function() use ($app) {
    // TODO: Add landing page
    $app->redirect($app->urlFor('movies'));
});

$app->get('/movies', function() use ($app) {
    $conn = new MySQLConnection();
    $movies = $conn->getMovies();
    $app->render('movies', array('movies' => $movies));
})->name('movies');

$app->get('/movies/new', function() use ($app) {
    $app->render('add_movie');
});

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

$app->get('/people', function() use ($app) {
    $conn = new MySQLConnection();
    $people = $conn->getPeople();
    $app->render('people', array('people' => $people));
})->name('people');

$app->map('/people/:id', function($id) use ($app) {
    // TODO: Display edit for person
})->via('GET');

$app->run();