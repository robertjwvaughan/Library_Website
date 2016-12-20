<?php
	include("Header.php");
	include("mainMenu.php");
	
	session_start();
	
	//Checks if a use is signed in
	if (!isset($_SESSION['user']))
	{
		header("Location: Login.php");
	}//end if
	
	//Checks if offest was set
	if(!isset($_GET['offset']))
	{
		$offset = 0;
	}//end if
	else
	{
		$offset = $_GET['offset'];
	}//end else
	
	//Stores categories
	$catSearch = "SELECT * FROM category WHERE CategoryID";
	$catArray = array();
	$result = $conn->query($catSearch);
	$counter = 0;
	$catName = "";
	
	array_push($catArray, $catName);
	
	//Stores the catergory in an array
	if ($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			array_push($catArray, $row["CategoryDesc"]);
			$counter++;
		}//end while
	}//end if
	
	//Checks if a user has clicked a book to be reserved
	if (isset($_GET['unReserve']))
	{
		$unReserve = $_GET['unReserve'];
		$sql = "DELETE FROM Reservations WHERE ISBN = '$unReserve'";
		//print("Hi");
		
		//Checks if statement ran
		if ($conn->query($sql) === TRUE)
		{
			$sql = "UPDATE books SET Reserved = 'N' WHERE ISBN = '$unReserve'";
			
			//Checks if Update ran
			if ($conn->query($sql) === TRUE)
			{
				//Directs to new page
				header("Location: reserveBook.php");
			}//end if
			else
			{
				//Error handling
				print("<div id=\"redcenter\"><br>Update Error: Could not unreserve book<br><div>");
			}
		}//end if
		else
		{
			//Error handling
			print("<div id=\"redcenter\"><br>$unReserve cannot be unreserved<br><div>");
		}//end else
	}//end if
	
	//Saves user name from session to a variable
	$user = $_SESSION['user'];
	
	//Statement to retrieve data
	$sql = "SELECT Reservations.Username, Reservations.ISBN, books.BookTitle, books.Author, books.Category
	FROM books INNER JOIN Reservations ON books.ISBN = Reservations.ISBN WHERE Reservations.Username = '$user'";
	
	$result = $conn->query($sql);
	
	$amount = $result->num_rows;
	
	$numOfRows = $amount;
	
	//print("$amount");
	
	//Statement to retrieve data
	$sql = "SELECT Reservations.Username, Reservations.ISBN, books.BookTitle, books.Author, books.Category, books.Edition, books.Year
	FROM books INNER JOIN Reservations ON books.ISBN = Reservations.ISBN WHERE Reservations.Username = '$user' LIMIT 5 OFFSET $offset";
	
	$result = $conn->query($sql);
	
	//Condition to check for results
	if ($result->num_rows > 0)
	{
		print("<table id=\"nexttext\">");
		
		print("<tr>");
		
		print
		("
			<td id=\"horizontal\">ISBN</td>
			<td id=\"horizontal\">TITLE</td>
			<td id=\"horizontal\">AUTHOR</td>
			<td id=\"horizontal\">EDITION</td>
			<td id=\"horizontal\">YEAR</td>
			<td id=\"horizontal\">CATEGORY</td>
			<td id=\"horizontal\">UNRESERVE</td>
		");
		
		print("</tr>");
		
		// output data of each row
		while($row = $result->fetch_assoc())
		{
			if ($row["Username"] == $user)
			{
				print("<tr>");
				
					print ("<td>". $row["ISBN"] . "</td>");
					print ("<td>". $row["BookTitle"] . "</td>");
					print ("<td>". $row["Author"] . "</td>");
					print ("<td>". $row["Edition"] . "</td>");
					print ("<td>". $row["Year"] . "</td>");
					print ("<td>". $catArray[$row["Category"]] . "</td>");
					print ("<td><a id=\"menuText\" href=\"reserveBook.php?&unReserve=" . $row["ISBN"] . "\">Click to unreserve</a></td>");
					
				print("</tr>");
			}

		}//end while
		
		print("</table>");
		//print("$numOfRows");
		
		print("<div id=\"center\">");
		
		//Displays Next and Prev if enough data is present
		if(!($offset == 0))
		{
			print("<a id=\"submit\" style=\"text-decoration:none\" href=\"reserveBook.php?offset=" .($offset - 5). "\">Prev</a>");
			print("\t");
		}//end if
		if (($offset + 5) < $numOfRows)
		{
			print("<a id=\"submit\" style=\"text-decoration:none\"href=\"reserveBook.php?offset=" .($offset + 5). "\">Next</a>");
		}//end if
		print("</div>");

	}//end if
	else
	{
		print("<div id=\"red\">");
			print("<h2 align=\"center\">No books have been reserved under your account</h6>");
		print("</div>");
	}
	
	include("Footer.php");
?>