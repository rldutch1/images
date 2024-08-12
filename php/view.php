<?php

include("pw5pdo.php");

?>

<!doctype html>
<html>
<head>
	<title></title>
</head>
<body>
<a href='../index.php'>Back</a><br />
	<?php
	$statement = $handler->prepare("select * from images where active_ind = 1");
	$statement->execute();
	$imagesList = $statement->fetchAll();
	
	foreach($imagesList as $image) {
	?>
	<img src="../<?= $image['image'] ?>" title="<?= $image['name'] ?>" width='200' height='200'>
	<?php
	}
	?>
<br />
<a href='../index.php'>Back</a>
</body>
</html>
