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

$app->get('/', function() use ($app) {
    $app->redirect($app->urlFor('movies'));
}); 

$app->get('/movies', function() use ($app) {
    $conn = new MySQLConnection();
	$movies = $conn->getMovies();
	$app->render('movies', array('movies' => $movies));
})->name('movies'); 

$app->get('/hello/:name/', function ($name) use ($app) {
    //echo "Hello, $name";
	$app->render('hello', array('name' => $name));
});

$app->run();