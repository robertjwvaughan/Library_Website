<?php
	include("Header.php");
	include("mainMenu.php");
	
	session_start();
	
	if (!isset($_SESSION['user']))
	{
		header("Location: Login.php");
	}//end if
	
	$user = $_SESSION['user'];
	
	//Gets the first name associated with the username
	$search = "SELECT FirstName FROM User WHERE Username = '" . $user . "'";
	
	$result = $conn->query($search);
	
	print("<div id=\"Home\">");
	print
	("
		<h1 id=\"center\">
			Pearse Street IT Library
		</h1>
	");
	
	if ($result->num_rows > 0) 
	{
		// output data of each row
		while($row = $result->fetch_assoc())
		{
			$name = $row['FirstName'];
			print
			("
				<h3 id=\"center\">
					Hello $name
				</h3>
			");
		}//end while
	}//end if
	
	//Gets books reserved by user
	$search = "SELECT * FROM Reservations WHERE Username = '" . $user . "'";
	
	$result = $conn->query($search);
	
	$rowCount = $result->num_rows;
	
	//Checks if there are 1 or more books for correct grammar output
	if ($rowCount == 1)
	{
		print
		("
			<h3 id=\"center\">
				You have $rowCount book reserved
			</h3>
		");
	}//end if
	else
	{
		print
		("
			<h3 id=\"center\">
				You have $rowCount books reserved
			</h3>
		");
	}
	
	//Prints an image on screen
	print
	("
		<img src=\"book.png\" alt=\"Book\" align=\"middle\" style=\"width:25%;height:250px;\">
	");
	
	include("Footer.php");
?>
