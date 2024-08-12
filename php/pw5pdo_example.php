<?php
//PDO connect method:
try {
	$handler = new PDO('mysql:host=127.0.0.1;dbname=TheDBName', 'TheDBUsername', 'TheDBUserPassword'); //Setting the handler. See next line if this line fails.
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Setting the attributes for the handler that we want to see if exception error.
}
//global $handler
catch(PDOException $e) { //Return the PDO exception and naming it $e.
//	echo 'Caught';
//	die('Sorry database problem.'); //Production message.
	echo $e->getMessage(); //Show specific error message. Development.
}
//DO NOT PUT A SPACE OR CARRIAGE RETURN AFTER THE END TAG. IT WILL SEND HEADER INFORMATION TO PAGES THAT ARE PURE PHP.
?>
