<?php
	include("Header.php");
	
	session_start();
	
	$check = 0;
	
	$name = "";
	$pass = "";
	$confirm = "";
	$FirstName = "";
	$LastName = "";
	$AddressLine1 = "";
	$AddressLine2 = "";
	$City = "";
	$Telephone = "";
	$Mobile = "";

	//Checks if a post was made to the page
	if (!empty($_POST['username']))
	{
		//Loads all data into variables
		$name = $_POST['username'];
		$pass = $_POST['password'];
		$confirm = $_POST['confimPassword'];
		$FirstName = $_POST['fname'];
		$LastName = $_POST['lname'];
		$AddressLine1 = $_POST['address1'];
		$AddressLine2 = $_POST['address2'];
		$City = $_POST['city'];
		$Telephone = $_POST['telephone'];
		$Mobile = $_POST['mobile'];
		
		$length = strlen($Mobile);
		$passSize = strlen($pass);
		
		if($pass == $confirm && $passSize >= 6 && $length == 10 && is_numeric($Mobile) && (is_numeric($Telephone) || empty($Telephone)))
		{
			//Select statement queried to database
			$nameCheck = "SELECT username FROM user WHERE username = '$name'";
			$result = $conn->query($nameCheck);
			
			//Checks the if the statement is true
			if ($result->num_rows == 0) 
			{
				//Insert statement
				$sql = "INSERT INTO User VALUES('$name', '$pass', '$FirstName', '$LastName', '$AddressLine1', '$AddressLine2', '$City', '$Telephone', '$Mobile')";
				
				//Checks if query returns true
				if ($conn->query($sql) === TRUE)
				{
					//Loads name into session
					if (!(isset($_SESSION['user'])))
					{
						$_SESSION['user'] = $name;
					}//end if
					
					//Checks if the session element is set
					if (!(isset($_SESSION['user']))) 
					{
						print("<div id=\"center\"><br>Failed to create a session<br></div>");
						$check = 1;
					}//end if
					else
					{
						$conn->close();
						header("Location: Home.php");
					}
				}//end if
				else
				{
					//Erroe checking
					echo "<div id=\"center\"><br>Error: " . $sql . "<br>" . $conn->error ."<br></div>";
					$check = 1;
				}//end else
			}//end if
			else
			{
				//Informs user that the user name is already used
				print("<div id=\"redcenter\"><br>Username in use<br></div>");
			}//end else
		}//end if
		else
		{
			print("<div id=\"redcenter\">");
			
				if ($pass != $confirm)
				{
					print("<br>Password does not match<br>");
				}//end if
				if ($passSize < 6)
				{
					print("<br>Password length is too short<br>");
				}//end if
				if ($length < 10)
				{
					print("<br>Phone number is not valid<br>");
				}//end if
				if (!(is_numeric($Telephone)) && !empty($Telephone))
				{
					print("<br>Telephone must have numeric values<br>");
				}//end if
				if (!(is_numeric($Mobile)) && !empty($Mobile))
				{
					print("<br>Mobile must have numeric values<br>");
				}//end if
				
			print("</div>");
		}//end else
	}//end if
	
	if ($check = 1)
	{
		//Prints form to submit information
		print
		("
			<div id=\"center\">
			<h2 id=\"blueText\">Signup Today!</h2>
				<form action=\"\" method=\"post\">
				
				<label id = \"red\">&#8727</label>
				Username
				<br>
					<input type=\"text\" name=\"username\" value=\"$name\" maxlength=\"30\" required>
				<br>
				
				<label id = \"red\">&#8727</label>
				Password
				<br>
					<input type=\"password\" name=\"password\" maxlength=\"30\" required>
				<br>
				
				<label id = \"red\">&#8727</label>
				Confirm Password
				<br>
					<input type=\"password\" name=\"confimPassword\" maxlength=\"30\" required>
				<br>
				
				<label id = \"red\">&#8727</label> 
				Firstname
				<br>
					<input type=\"text\" name=\"fname\" value=\"$FirstName\" maxlength=\"30\" required>
				<br>
				
				<label id = \"red\">&#8727</label> 
				Lastname
				<br>
					<input type=\"text\" name=\"lname\" value=\"$LastName\" maxlength=\"30\" required>
				<br>
				
				<label id = \"red\">&#8727</label> 
				Address Line 1
				<br>
					<input type=\"text\" name=\"address1\" value=\"$AddressLine1\" maxlength=\"25\" required>
				<br>
				
				<label id = \"red\">&#8727</label> 
				Address Line 2
				<br>
					<input type=\"text\" name=\"address2\" value=\"$AddressLine2\" maxlength=\"25\" required>
				<br>
				
				<label id = \"red\">&#8727</label> 
				City
				<br>
					<input type=\"text\" name=\"city\" value=\"$City\" maxlength=\"25\" required>
				<br>
				
				<label id = \"red\">&#8727</label>
				Mobile
				<br>
					<input type=\"text\" name=\"mobile\" value=\"$Mobile\" maxlength=\"10\" required>
				<br>
					 
				Telephone
				<br>
					<input type=\"text\" name=\"telephone\" value=\"$Telephone\" maxlength=\"10\">
				<br>
				
				<br>

				<input type=\"submit\" value=\"Submit\" id=\"submit\">
				
				<br>
				
				<h3>Already a member? <a id=\"blueText\" style=\"text-decoration:none\" href=\"Login.php\">Log in</a></h3>
				</form>
			<br>
			</div>
		");
	}//end else
		
	include("Footer.php");
?>