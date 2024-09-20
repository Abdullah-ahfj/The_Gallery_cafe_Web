<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Selecting MYSQL Databse</title>
<style>
        


        
    </style>
</head>

<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if (!$conn) {
		die("Could not connect: " . mysqli_error($conn));
	}

	//echo 'Connected Successfully';

	// Selecting the database
	$db_selected = mysqli_select_db($conn, '110sql');

	if (!$db_selected) {
		die('Could not select database: ' . mysqli_error($conn));
	} else {
		//echo 'Database selected';
	}

	// You can close the connection if needed
	// mysqli_close($conn);
?>


<body>


</body>
</html>