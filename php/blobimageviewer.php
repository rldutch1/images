<?php
// ----------------------------------------------------------------------------
// Script Author: Robert Holland 
// Script Name: 
// Creation Date: Thu Apr 04 2024 16:39:43 GMT-0700 (MST)
// Last Modified: 
// Copyright (c)2024
// Version: 1.0.0 
// Purpose: Extract PDF content from MySQL database table field.
// This file is read only and does not need to be modified to work.
// ----------------------------------------------------------------------------

// Make a database connection
include('../pw_ffl.php');
//Get current filename so this code can be reused for different filenames.
$thisfile = basename(__FILE__);
//Specify table name in one place.
$tablename = "ffl_4473_docs";

//Look for an argument from the commandline:
if ($argc<2){
   echo "Enter the ID of the image.\r\n Example usage: php -f {$thisfile} ### \r\n";
   die();
} else{
   $inv_num = "";
	//echo "Argc is: " . $argc . "\r\n";
   if (isset($argv)) {
   $inv_num = $argv[$argc-1];
   }
    //echo "Fetching 4473 for inventory number {$inv_num}. \r\n";
    	$pdf_extract = new Connection(); //Instantiate a new connection.
		//Insert PDF data along with other field data.
			$pdf_extract->myQuery('SELECT image FROM ' . $tablename . ' where inv_num = :inv_num;');
			$pdf_extract->bind(':inv_num', $inv_num);
		//Execute the query.
			$pdf_data = $pdf_extract->SingleRow();
		//Create/open the PDF document for writing:
			$pdf_file = fopen("InvNum_" . $inv_num . "_4473.pdf", "w") or die("Unable to open file!");
		//Write data to the PDF document:

		foreach($pdf_data as $pdf){
			fwrite($pdf_file, $pdf);
			echo "Fetching 4473 for inventory number {$inv_num} as InvNum_" . $inv_num . "_4473.pdf\r\n";
		}

		//Close the PDF document.
			fclose($pdf_file);
}


?>