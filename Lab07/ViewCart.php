<?php // <--- do NOT put anything before this PHP tag

include('functions.php');

// get the cookieMessage, this must be done before any HTML is sent to the browser.
$cookieMessage = getCookieMessage();

?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" /> 
		<title>Your Cart</title>
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
			<?php

			// does the user have items in the shopping cart?
			if(isset($_COOKIE['ShoppingCart']) && $_COOKIE['ShoppingCart'] != '')
			{
				// the shopping cart cookie contains a list of productIDs separated by commas
				// we need to split this string into an array by exploding it.
				$productID_list = explode(",", $_COOKIE['ShoppingCart']);
				
				// remove any duplicate items from the cart. although this should never happen we 
				// must make absolutely sure because if we don't we might get a primary key violation.
				$productID_list = array_unique($productID_list);
				//print_r($productID_list);
				$dbh = connectToDatabase();

				// create a SQL statement to select the product and brand info about a given ProductID
				// this SQL statement will be very similar to the one in ViewProduct.php
				// TODO the complete this SQL statment, you should read lectures 14 and 5.
				$statement = $dbh->prepare('SELECT * FROM Products INNER JOIN Brands
									ON Brands.BrandID = Products.BrandID
									WHERE Products.ProductID = ? ');

				$totalPrice = 0;
				
				echo "<div class = 'OrderDetailProducts'>";
				echo "<table>";
					echo "<tr>";
						echo "<th>Product</th>";
						echo "<th>Description</th>";
						echo "<th>Brand</th>";
						echo "<th>Subtotal</th>";
					echo "</tr>";
				
				// loop over the productIDs that were in the shopping cart.
				foreach($productID_list as $productID)
				{
					// great thing about prepared statements is that we can use them multiple times.
					// bind the first question mark to the productID in the shopping cart.
					$statement->bindValue(1,$productID);
					$statement->execute();
					
					// did we find a match?
					if($row = $statement->fetch(PDO::FETCH_ASSOC))
					{				
						//TODO Output information about the product. including pictures, description, brand etc.				
						//TODO add the price of this item to the $totalPrice
						$ProductID = makeOutputSafe($row['ProductID']); 
						$Description = makeOutputSafe($row['Description']); 
						$BrandID = makeOutputSafe($row['BrandID']); 
						$BrandName = makeOutputSafe($row['BrandName']); 
						$UnitPrice = makeOutputSafe($row['Price']); 
						
						echo "<tr>";
							echo "<td> <img src = '../IFU_Assets/ProductPictures/$ProductID.jpg' alt= 'productID' /></td>";
							echo "<td> $Description</td>";
							echo "<td> <img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID' /></td>";
							echo "<td>$$UnitPrice</td>";
						echo "</tr>";
						
						
						$totalPrice = $UnitPrice + $totalPrice;
					}
				}
				echo "</table>";
				echo "</div>";
				// TODO: output the $totalPrice.
				//echo "Total Price = $$totalPrice";
				$formattedTotalPrice = number_format($totalPrice,1);
				
				echo "<div class = 'TotalPrice'>";
				echo "<table>";
				echo "<tr>";
					echo "<td><b>Total Cost</b></td>";
					echo "<td><b>$$formattedTotalPrice</b></td>";
				echo "</tr>";
				
						
				//echo "Total Price = $$formattedTotalPrice";
				// if we have any error messages echo them now. TODO style this message so that it is noticeable.
				
				
				// you are allowed to stop and start the PHP tags so you don't need to use lots of echo statements.
				
					
					echo"<form action = 'ProcessOrder.php' method = 'POST'>";
					echo"<tr>";
					echo"<td colspan = '2'><input type = 'text' name = 'UserName' id = 'UserName' placeholder = 'Enter Valid Username'/></td>";
					echo"</tr>";
					echo"<tr>";
						 echo"<td><input type = 'submit' name = 'ConfirmOrder' value = 'Confirm Order' id = 'ConfirmOrder' /></td>";
					echo"</form>";
					
					echo"<form action = 'EmptyCart.php' method = 'POST'>";
						echo"<td><input type = 'submit' name = 'EmptyCart' value = 'Empty Shopping Cart' id = 'EmptyCart' /></td>";
					echo"</form>";
					echo"</tr>";
					echo"<tr>";
					echo "<td colspan = '2'><div class = 'error_message'>$cookieMessage</div></td>";
					echo"</tr>";
					echo"</table>";
					echo"</div>";
					
					
				?>
				<?php 		
			}
			else
			{
				// if we have any error messages echo them now. TODO style this message so that it is noticeable.
				echo "<div class = 'error_message'>";
				echo "$cookieMessage <br/>";
				
				echo "You Have no items in your cart!";
				echo"</div>";
			}
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
