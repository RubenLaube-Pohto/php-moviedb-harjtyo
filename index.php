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
// Set css file to use
$app->view->getEngine()->addData(array('maincss' => 'http://student.labranet.jamk.fi/~H8871/www/palvelinohjelmointi/php-moviedb-harjtyo/static/main.css'), 'template');

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

$app->run();