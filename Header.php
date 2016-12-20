<html>
	<head>
		<title>PIT Library</title>
		<!--To link stylesheet-->
		<link rel = "stylesheet" type = "text/css" href = "format.css">
	</head>
	
	<body>
	
	<!--Banner-->
	<div class = "header">
		<p class = "banner">PIT Library</p>
	</div>
	
	<div class = "main">
	
	<!--Database connection-->
	<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "library";
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}//end if
	?>
	