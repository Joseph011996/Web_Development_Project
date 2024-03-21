<?php // <--- do NOT put anything before this PHP tag
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" /> 
		<title>Welcome Owner</title>
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
			<div class = 'tablelist'>
			<?php 	
				echo "<div class = 'message'>";
				echo $cookieMessage;
				echo "</div>";
				
				echo "<table>";
					echo "<tr>";
						echo "<th>Product ID</th>";
						echo "<th>Description</th>";
						echo "<th>Unit Price</th>";
						echo "<th>Brand</th>";
						echo "<th>Popularity</th>";
						echo "<th>Total Quantity</th>";
						echo "<th>Total Revenue</th>";
					echo "</tr>";
					
				$dbh = connectToDatabase();	
				
				$statement2 = $dbh->prepare('SELECT Products.ProductID, Products.Description, Products.Price, 
							Products.BrandID, COUNT(Products.ProductID) AS Popularity, SUM(OrderProducts.Quantity) AS TotalQuantity, Brands.BrandName
							FROM Products LEFT JOIN OrderProducts
							ON OrderProducts.ProductID = Products.ProductID
							LEFT JOIN Brands
							ON Products.BrandID = Brands.BrandID
							GROUP BY Products.ProductID
							ORDER BY (TotalQuantity *  Products.Price) DESC
							;');			

				$statement2->execute();
				
				while($row = $statement2->fetch(PDO::FETCH_ASSOC))
				{
				$ProductID = htmlspecialchars($row['ProductID'], ENT_QUOTES, 'UTF-8'); 
				$Description = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8');
				$Price = htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8'); 
				$BrandID = htmlspecialchars($row['BrandID'], ENT_QUOTES, 'UTF-8');
				$Popularity = htmlspecialchars($row['Popularity'], ENT_QUOTES, 'UTF-8');
				$TotalQuantity = htmlspecialchars($row['TotalQuantity'], ENT_QUOTES, 'UTF-8');
				$BrandName = htmlspecialchars($row['BrandName'], ENT_QUOTES, 'UTF-8');
				
				$TotalRevenue = $Price * $TotalQuantity;
				$formattedTotalRevenue = number_format($TotalRevenue,1);
				
					echo "<tr>";
						echo "<td><a href='../Lab07/ViewProduct.php?ProductID=$ProductID'>$ProductID</a></td>";
						echo "<td>$Description </td>";
						echo "<td>$$Price </td>";
						echo "<td>$BrandName</td>";
						echo "<td> $Popularity </td>";
						echo "<td>$TotalQuantity </td>";
						echo "<td>$$formattedTotalRevenue </td>";
					echo "</tr>";
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