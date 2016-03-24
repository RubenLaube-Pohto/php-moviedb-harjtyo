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

$app->get('/', function() {
    echo "Home Page<br>".
		 "<a href='hello/ossi'>linkki</a>";
	// Connect to database
	require_once ("db.php");
	$hakuehto = "";
	$stmt = haeHenkilot($db, $hakuehto);
	sqlResult2Html($stmt);
}); 

$app->get('/hello/:name/', function ($name) use ($app) {
    //echo "Hello, $name";
	$app->render('hello', array('name' => $name));
});

$app->run();

function haeHenkilot($db, $hakuehto) {
   $sql = <<<SQLEND
   SELECT tunnus, sukunimi, etunimi, email, osoite, puhnro
   FROM henkilot2 WHERE sukunimi
   LIKE :hakuehto
SQLEND;
 
   $stmt = $db->prepare("$sql");
   $stmt->bindValue(':hakuehto', "%$hakuehto%", PDO::PARAM_STR);
   $stmt->execute();
   return $stmt;    
}

// SQL-kyselyn tulosjoukko HTML-taulukkoon.
function sqlResult2Html($stmt) {
	$row_count = $stmt->rowCount();
	$col_count  = $stmt->columnCount();
	
	echo "Hakutulokset:" . $row_count. " riviä:<hr>\n";
	echo "<table border='0'>\n";  
	$output = <<<OUTPUTEND
	<tr bgcolor='#ffeedd'>
	<td>Tunnus</td><td>Sukunimi</td><td>Etunimi</td>
	<td>Osoite</td><td>Puhnro</td><td>Email</td>
	</tr>
OUTPUTEND;
	echo $output;
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$output = <<<OUTPUTEND
		<tr>
		<td><a href='h7-osoitekirja-muokkaa.php?id={$row['tunnus']}'>{$row['tunnus']}</a></td><td>{$row['sukunimi']}</td><td>{$row['etunimi']}</td>
		<td>{$row['osoite']}</td><td>{$row['puhnro']}</td><td>{$row['email']}</td>
	   </tr>
OUTPUTEND;
		echo $output;
	}
	echo "</table>\n";
}