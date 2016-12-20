<?php
	include("Header.php");
	
	//Starts session
	session_start();
	
	//Checks if a user signed in
	if (isset($_SESSION['user']))
	{
		header("Location: Home.php");
	}//end if
	
	//Checks if a post was made to the page to login
	if (!empty($_POST['password']) && !empty($_POST['username']))
	{
		$name = $_POST['username'];
		$pass = $_POST['password'];
		$sql = "SELECT username FROM user WHERE username = '$name' AND password = '$pass'";
		$result = $conn->query($sql);
		
		//Checks if a user exits
		if ($result->num_rows == 1)
		{
			$_SESSION['user'] = $name;
			header("Location: Home.php");
		}//end if
		else
		{
			//Login fai message
			print("<div id=\"redcenter\"><br>Login fail<br></div>");
		}//end else 
	}//end if
	
	//Prints login table
	print
	("
		<br>
		<div align=\"center\">
			<form action=\"\" method=\"post\">
				Username
				<br>
				<!--Username-->
				<input type=\"text\" name=\"username\" maxlength=\"30\" required>
				<br>
				Password
				<br>
				<!--Password-->
				<input type=\"password\" name=\"password\" maxlength=\"30\" required>
				<br><br>
				<!--Submit-->
				<input type=\"submit\" value=\"Submit\" id=\"submit\">
				<br><br>
				<h3>Not a member? <a id=\"blueText\" style=\"text-decoration:none\" href=\"Register.php\">Register</a></h3>
			</form>
		</div>
	");
	//Loads footer
	include("Footer.php");
?>
