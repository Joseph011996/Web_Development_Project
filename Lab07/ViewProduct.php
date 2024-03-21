<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" /> 
		<title> View Product</title>
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
		<h2>Add To Your Cart</h2>
		<?php 
			
			// include some functions from another file.
			include('functions.php');
			
			if(isset($_GET['ProductID']))
			{		
				$productIDURL = $_GET['ProductID'];
				// connect to the database using our function (and enable errors, etc)
				$dbh = connectToDatabase();
				
				// select all the products with the specified ID.
				$statement = $dbh->prepare('SELECT * FROM Products INNER JOIN Brands
								ON Brands.BrandID = Products.BrandID
								WHERE Products.ProductID = ? ');
				
				// TODO: bind the value here
				$statement->bindValue(1,$productIDURL);
				
				//execute the SQL.
				$statement->execute();

				// get the result, there will only ever be one product with a given ID (because products ids must be unique)
				// so we can just use an if() rather than a while()
				if($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					// display the details here.
					$Price = htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8'); 
					$Description = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8'); 
					$BrandName = htmlspecialchars($row['BrandName'], ENT_QUOTES, 'UTF-8'); 
					$BrandID = htmlspecialchars($row['BrandID'], ENT_QUOTES, 'UTF-8'); 
					$BrandURL = htmlspecialchars($row['Website'], ENT_QUOTES, 'UTF-8'); 
					$ProductID = htmlspecialchars($row['ProductID'], ENT_QUOTES, 'UTF-8'); 
					
					// output the data in a div with a class of 'productBox' we can apply css to this class.
					echo "<div class = 'ViewProductDetail'>";
					echo "<table>";
					echo "<tr>";
					echo "<td><img src = '../IFU_Assets/ProductPictures/$productIDURL.jpg' alt= 'productID' /></td>";
					echo "<td>$Description <br/>$$Price <br/><a href='$BrandURL'>$BrandName</a></td>";
					echo "<td><a href='$BrandURL'><img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID' /></a></td>";
					echo "</tr>";
					echo "</table>";
					echo "\n";	
				}
				else
				{
					echo "Unknown Product ID";
				}
			}
			else
			{
				echo "No ProductID provided!";
			}
			
			if(DoesCartContainProduct($ProductID))
			{
				echo "<div class = 'message'>";
				echo "You have this item in your cart";
				echo "</div>";
			}
			else
			{
				echo "<form method = 'POST' action = 'AddToCart.php?ProductID=$productIDURL'>";
				echo "<input type = 'submit' name = 'BuyButton' value = 'Buy Now' id = 'BuyButton' />";
				echo "</form>";
			
			}
			echo "</div>";
			
		?>
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