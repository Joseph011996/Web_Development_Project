<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" /> 
		<title>Customer List</title>
		<link rel="stylesheet" type="text/css" href="shopstyle.css" />
	</head>  
	<body>
		<header>
		<nav class = "navbar">
			<ul>
			  <li><img src = "images/logo21.jpg" alt = "small logo"></li>
			  <li><a href="Homepage.php">Home</a></li>
			  <li><a href="ProductList.php">Products</a></li>
			  <li><a href="ViewCart.php">View Cart</a></li>
			  <li><a href="CustomerList.php">Customers</a></li>
			  <li><a href="OrderList.php">Orders</a></li>
			  <li><a href="SignUp.php">Sign Up</a></li>
			  <li><a href="admin.php">Admin</a></li>
			</ul>
		</nav>
		</header>
		<div class = "pagecontent">
		<br/>
			<div class = "tablelist">
			<?php
			//<h1> Customer List </h1>
				include('functions.php');
				
				echo "<table>";
					echo "<tr>";
						echo "<th>Customer ID</th>";
						echo "<th>First Name</th>";
						echo "<th>Last Name</th>";
						echo "<th>Street Address</th>";
						echo "<th>City</th>";
					echo "</tr>";
				
				$dbh = connectToDatabase();
				
				$statement = $dbh->prepare('SELECT * FROM Customers');
				
				$statement->execute();
				
				while($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$CustID = htmlspecialchars($row['CustomerID'], ENT_QUOTES, 'UTF-8'); 
					$FName = htmlspecialchars($row['FirstName'], ENT_QUOTES, 'UTF-8'); 
					$LName = htmlspecialchars($row['LastName'], ENT_QUOTES, 'UTF-8'); 
					$CustAddress = htmlspecialchars($row['Address'], ENT_QUOTES, 'UTF-8'); 
					$CustCity = htmlspecialchars($row['City'], ENT_QUOTES, 'UTF-8'); 
					
					//echo "<div class = 'customers'>";
					echo "<tr>";
						echo "<td>$CustID</td>";
						echo "<td>$FName</td>";
						echo "<td>$LName</td>";
						echo "<td>$CustAddress</td>";
						echo "<td>$CustCity </td>";
					echo "</tr>";
					//echo "</div>";
				}
				echo "</table>"; 	
			?>
			</div>
		</div>
		<footer>
			<div class = "footerLeft">
				<h1> ZAP </h1>
				<p> An exciting place for the whole family to shop. Few clicks is all it takes. </p>
				<i> Contact No: 123-456-789 </i>
				<br/>
				<i> Email: info@zap.com </i>
			</div>	
			<div class = "footerRight">
				<h1>Leave a comment</h1>
				<form action = "comment.php" method = "POST">
					<input type = "text" name = "commentname" id = "commentname" placeholder = "Enter your name" /><br/>
					<input type = "text" name = "commentmessage" id = "commentmessage" placeholder = "Enter your message"/><br/>
					<input type = "submit" value = "Comment" id = "commentbutton"/>		
				</form>
			</div>
		</footer>
	</body>
</html>
