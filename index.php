<?php
//Source: https://makitweb.com/upload-multiple-image-files-to-the-database-using-pdo-php/
include "php/pw5pdo.php";

if(isset($_POST['submit'])){ //If submit has been clicked.

  // Count total files
  $countfiles = count($_FILES['files']['name']); //Count the number of files that have been selected.

  // Prepared statement
$statement=$handler->prepare("INSERT INTO images (name,image,extension) VALUES(?,?,?);");

  // Loop all files
  for($i=0;$i<$countfiles;$i++){ //Iterate through the number of files.

    // File name
    $filename = $_FILES['files']['name'][$i];

    // Location
    $target_file = 'upload/'.$filename; //Upload directory.

    // file extension
    $file_extension = pathinfo($target_file, PATHINFO_EXTENSION); //Grab the file extension.
    $file_extension = strtolower($file_extension); //Change the file extension to lowercase.

    // Valid image extension
    $valid_extension = array("png","PNG","jpeg","JPEG","jpg","JPG","pdf","PDF","txt","TXT"); //Only allow these extension types.

    if(in_array($file_extension, $valid_extension)){ //Verify the file extension.

       // Upload file
       if(move_uploaded_file($_FILES['files']['tmp_name'][$i],$target_file)){ //Write files to upload directory.

          // Execute query
	  $statement->execute(array($filename,$target_file,$file_extension)); //Add filename and extension to database table.

       }
    }

  }
  echo "File(s) successfully uploaded.";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="Template HTML Document">
<meta name="keywords" content="comma,separated,keywords">
<meta name="author" content="Robert Holland">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<script type="text/javascript" src="http://example.com/js/filename.js"></script>
<link rel="stylesheet" href="http://example.com/css/filname.css" />
</head>

<style>
/*common css*/
table, th, td {border-collapse:collapse; border: 1px solid black;}
th {background-color:#ffff00;}
tr:nth-child(even) {background: #CCC;}
tr:nth-child(odd) {background: #FFF;}
a:link {text-decoration: none;}
a:visited {text-decoration: none;}
a:hover {text-decoration: underline;}
a:active {text-decoration: underline;}
</style>

<body>

<form method='post' action='' enctype='multipart/form-data'>
  <input type='file' name='files[]' multiple />
  <input type='submit' value='Submit' name='submit' />
</form>
<br />
<a href='php/view.php' target='_blank'>View Pics</a>


</body>
</html>


