<?php
	include("Header.php");
	include("mainMenu.php");
	
	session_start();
	
	//Checks whether a user has logged in
	if (!isset($_SESSION['user']))
	{
		header("Location: Login.php");
	}//end if
	
	//Checks if a page change was made
	if(!isset($_GET['offset']))
	{
		$offset = 0;
	}//end if
	else
	{
		$offset = $_GET['offset'];
	}//end else
	
	//Sotres all categories in an array
	$catSearch = "SELECT * FROM category WHERE CategoryID";
	$catArray = array();
	$result = $conn->query($catSearch);
	$counter = 0;
	$catName = "";
	
	array_push($catArray, $catName);
	
	//Loop to store are categories in an array
	if ($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			array_push($catArray, $row["CategoryDesc"]);
		}//end while
	}//end if
	
	//Check to see whether a user reserved a book
	if (isset($_GET['reserve']))
	{
		$reserve = $_GET['reserve'];
		
		//Statement to search whether book is unreserved
		$search = "SELECT * FROM books WHERE ISBN = '$reserve' AND Reserved = 'N'";
		
		$result = $conn->query($search);
		
		//Check to see if the book is free
		if ($result->num_rows == 1)
		{
			$sql = "UPDATE books SET Reserved = 'Y' WHERE ISBN = '$reserve'";
			
			//If error occurs, user is informed
			if ($conn->query($sql) === FALSE)
			{
				print("<div id=\"center\"><br>Cannot reserve this book. Please try again later2<br><br>");
			}//end if
			else
			{
				//Storing of date and user name
				$date = date("Y-m-d");
				$user = $_SESSION['user'];
				
				//print("INSERT INTO reservations VALUES('$reserve', '$user', '$date')");
				
				//Inserting values into the reservations table
				$sql = "INSERT INTO Reservations VALUES('$reserve', '$user', '$date')";
				
				//Checks whether the statement ran
				if ($conn->query($sql) === TRUE)
				{
					print("<div id=\"center\"><br>Book Reserved<br><br></div>");
				}//end if
				else
				{
					//Prints an error message
					print("<div id=\"center\"><br>Cannot reserve this book. Please try again later3<br><br></div>");
				}//end else
			}//end else
		}//end if
		else
		{
			//If the book is reserved already
			print("<div id=\"center\"><br>Cannot reserve this book. Please try again later1<br><br></div>");
		}//end else
	}//end if
	
	/*
		Print of table form
	*/
	
	print
	("
		<form action=\"\" method=\"get\">
			<table id=\"nexttext\">
			
			<tr>
				<td style=\"width:33%\">TITLE</td>
				<td style=\"width:33%\">AUTHOR</td>
				<td style=\"width:33%\">CATEGORY</td>
			</tr>
			
			<tr>
				<td style=\"width:33%\"><input type=\"text\" name=\"title\" maxlength=\"30\" style=\"width:100%\"></td>
				<td style=\"width:33%\"><input type=\"text\" name=\"author\" maxlength=\"30\" style=\"width:100%\"></td>
				<td style=\"width:33%\"><select style=\"width:100%\" name=\"category\">
	");
	
	//Retrieves the categories
	foreach ($catArray as $value)
	{
		print("<option value=\"$counter\">$value</option>");
		$counter++;
	}//end while
	
	//Continues printing html
	print
	("
				</select></td>
			</tr>
		
		<tr>
			<td colspan=\"5\"><input type=\"submit\" value=\"Submit\" id = \"submit\"></td>
		</tr>
		
		</table>
	</form>
	");
	
	//Checks if a search was made
	if (isset($_GET['title']) || isset($_GET['author']) || isset($_GET['category']))
	{
		$title = $_GET['title'];
		$author = $_GET['author'];
		$cat = $_GET['category'];
		
		//Checks search values and number of requeired rows
		if ($cat == 0)
		{
			$search = "SELECT * FROM books WHERE BookTitle LIKE '%" . $title . "%' AND Author LIKE '%" . $author . "%'";
			$result = $conn->query($search);
			$numRows = $result->num_rows;
			$search = "SELECT * FROM books WHERE BookTitle LIKE '%" . $title . "%' AND Author LIKE '%" . $author . "%' LIMIT 5 OFFSET $offset";
		}//end if
		else
		{
			$search = "SELECT * FROM books WHERE BookTitle LIKE '%" . $title . "%' AND Author LIKE '%" . $author . "%' AND Category LIKE '%" . $cat . "%'";
			$result = $conn->query($search);
			$numRows = $result->num_rows;
			$search = "SELECT * FROM books WHERE BookTitle LIKE '%" . $title . "%' AND Author LIKE '%" . $author . "%' AND Category LIKE '%" . $cat . "%' LIMIT 5 OFFSET $offset";
		}//end else
		$result = $conn->query($search);
		
		if ($result->num_rows > 0)
		{
			print("<table id=\"nexttext\">");

			print("<tr>");

			print
			("
				<td id=\"horizontal\" width=\"13%\">ISBN</td>
				<td id=\"horizontal\">TITLE</td>
				<td id=\"horizontal\" width=\"13%\">AUTHOR</td>
				<td id=\"horizontal\">EDITION</td>
				<td id=\"horizontal\" width=\"13%\">YEAR</td>
				<td id=\"horizontal\" width=\"13%\">CATEGORY</td>
				<td id=\"horizontal\" width=\"13%\">RESERVE</td>
			");

			print("</tr>");

			// output data of each row
			while($row = $result->fetch_assoc())
			{
				print("<tr>");
					
					print ("<td width=\"13%\">". $row["ISBN"] . "</td>");
					print ("<td>". $row["BookTitle"] . "</td>");
					print ("<td width=\"13%\">". $row["Author"] . "</td>");
					print ("<td width=\"13%\">". $row["Edition"] . "</td>");
					print ("<td width=\"13%\">". $row["Year"] . "</td>");
					print ("<td width=\"13%\">". $catArray[$row["Category"]] . "</td>");
					
					if ($row["Reserved"] == 'Y' && $row["Reserved"])
					{
						print ("<td width=\"14.28%\">Reserved</td>");
					}//end if
					else 
					{
						print ("<td width=\"13%\"><a a id=\"menuText\" href=\"searchBook.php?title=$title&author=$author&category=$cat&offset=$offset&reserve=" . $row["ISBN"] . "\">Reserve</a></td>");
					}//end if

				print("</tr>");
			}//end while

			print("</table>");
		}//end if
		else
		{
			header("Location: searchBook.php?error=0");
		}//end else
		
		print("<br>");
		print("<div id=\"center\">");
		if(!($offset == 0))
		{
			print("<a id=\"submit\" style=\"text-decoration:none\" href=\"searchBook.php?title=$title&author=$author&category=$cat&offset=" .($offset - 5). "\">Prev</a>");print("\t");
			print("\t");
		}//end if
		if ((($offset + 5) < $numRows))
		{
			print("<a id=\"submit\" style=\"text-decoration:none\" href=\"searchBook.php?title=$title&author=$author&category=$cat&offset=" .($offset + 5). "\">Next</a>");
		}
		print("</div>");
		
	}//end else
		
	if (isset($_GET['error']))
	{
		print("<div id=\"redcenter\"><h2 align=\"center\">No results<br></h2></div>");
	}//end if
	
	include("Footer.php");
?>