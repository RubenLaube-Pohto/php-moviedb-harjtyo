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

require_once 'mysqlconn.php';
require_once 'movie.php';

$app->get('/', function() use ($app) {
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

$app->get('/movies/:id', function($id) use ($app) {
    $conn = new MySQLConnection();
    $movie = $conn->getMovie($id);
    $app->render('edit_movie', array('movie' => $movie));
});

$app->put('/movies/:id', function($id) use ($app) {
    $conn = new MySQLConnection();
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
});

$app->delete('/movies/:id', function($id) use ($app) {
    $conn = new MySQLConnection();
    $conn->deleteMovie($id);
    $app->redirect($app->urlFor('movies'));
});

$app->get('/hello/:name/', function ($name) use ($app) {
    //echo "Hello, $name";
    $app->render('hello', array('name' => $name));
});

$app->run();