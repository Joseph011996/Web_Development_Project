<?php // <--- do NOT put anything before this PHP tag

include('functions.php');

// get the cookieMessage, this must be done before any HTML is sent to the browser.
$cookieMessage = getCookieMessage();

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Order Details</title>
		<link rel="stylesheet" type="text/css" href="shopstyle.css" />
		<meta charset="UTF-8" /> 
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
		
			<div id = "orderdetails">
			<?php

			echo "<div class = 'message'>";
			echo $cookieMessage;
			echo "</div>";
			
			// did the user provided an OrderID via the URL?
			if(isset($_GET['OrderID']))
			{
				$UnsafeOrderID = $_GET['OrderID'];
				
				$dbh = connectToDatabase();
				
				// select the order details and customer details. (you need to use an INNER JOIN)
				// but only show the row WHERE the OrderID is equal to $UnsafeOrderID.
				$statement = $dbh->prepare('
					SELECT * 
					FROM Orders 
					INNER JOIN Customers ON Customers.CustomerID = Orders.CustomerID 
					WHERE OrderID = ? ; 
				');
				$statement->bindValue(1,$UnsafeOrderID);
				$statement->execute();
				
				// did we get any results?
				if($row1 = $statement->fetch(PDO::FETCH_ASSOC))
				{
					// Output the Order Details.
					$FirstName = makeOutputSafe($row1['FirstName']); 
					$LastName = makeOutputSafe($row1['LastName']); 
					$Address = makeOutputSafe($row1['Address']); 
					$City = makeOutputSafe($row1['City']); 
					$dateTime = makeOutputSafe($row1['TimeStamp']); 
					$OrderID = makeOutputSafe($row1['OrderID']); 
					$UserName = makeOutputSafe($row1['UserName']); 
					$TimeStamp = date("Y/m/d h:i A ", $dateTime);
					
					// display the OrderID
					
					// its up to you how the data is displayed on the page. I have used a table as an example.
					// the first two are done for you.
					echo "<div class = 'OrderDetailCustomer'>";
					echo "<table>";
					echo "<tr><th>Order ID :</th><td>$OrderID</td></tr>";
					echo "<tr><th>UserName :</th><td>$UserName</td></tr>";
					echo "<tr><th>Customer Name :</th><td>$FirstName $LastName </td></tr>";
					echo "<tr><th>Address :</th><td>$Address, $City </td></tr>";
					echo "<tr><th>Order Time :</th><td>$TimeStamp </td></tr>";
					echo "</table>";
					echo "</div>";
					echo "<br/><br/>";
					//TODO show the Customers Address and City.
					//TODO show the date and time of the order.	
					
					// TODO: select all the products that are in this order (you need to use INNER JOIN)
					// this will involve three tables: OrderProducts, Products and Brands.
					
					$statement2 = $dbh->prepare('SELECT * FROM ((OrderProducts INNER JOIN Products 
							ON OrderProducts.ProductID = Products.ProductID)
							INNER JOIN Brands ON Products.BrandID = Brands.BrandID)
							WHERE OrderProducts.OrderID = ?');
				
					$statement2->bindValue(1,$UnsafeOrderID);
					$statement2->execute();
					
					$totalPrice = 0;
					
					echo "<div class = 'OrderDetailProducts'>";
					echo "<table>";
					echo "<tr>";
						echo "<th>Product</th>";
						echo "<th>Description</th>";
						echo "<th>Brand</th>";
						echo "<th>Quantity</th>";
						echo "<th>Subtotal</th>";
					echo "</tr>";
					
					// loop over the products in this order. 
					while($row2 = $statement2->fetch(PDO::FETCH_ASSOC))
					{
						//NOTE: pay close attention to the variable names.
						$ProductID = makeOutputSafe($row2['ProductID']); 
						$Description = makeOutputSafe($row2['Description']); 
						$BrandID = makeOutputSafe($row2['BrandID']); 
						$BrandName = makeOutputSafe($row2['BrandName']); 
						$UnitPrice = makeOutputSafe($row2['Price']); 
						$Quantity = makeOutputSafe($row2['Quantity']); 
						$subtotal = $UnitPrice * $Quantity;
						$formattedsubtotal = number_format($subtotal,1);

						echo "<tr>";
							echo "<td><a href='ViewProduct.php?ProductID=$ProductID'><img src = '../IFU_Assets/ProductPictures/$ProductID.jpg' alt= 'productID' /></a></td>";
							echo "<td>$Description <br/> $$UnitPrice  </td>";
							echo "<td><img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID' /></td>";
							echo "<td>$Quantity</td>";
							echo "<td>$$formattedsubtotal</td>";
						echo "</tr>";
						
						
						
						// TODO show the Products Description, Brand, Price, Picture of the Product and a picture of the Brand.
						// TODO The product Picture must also be a link to ViewProduct.php.
						$totalPrice = $totalPrice + $subtotal;
						// TODO add the price to the $totalPrice variable.
					}		
					//echo "Total Price = $$totalPrice";
					echo "</table>";
					echo "</div>";
					
					$formattedTotalPrice = number_format($totalPrice,1);
					
					echo "<div class = 'TotalPrice'>";
					echo "<table>";
					echo "<tr>";
					echo "<td><b>Total Cost</b></td>";
					echo "<td><b>$$formattedTotalPrice</b></td>";
					echo "</tr>";
					echo "</table>";
					echo "</div>";				
				}
				else 
				{
					echo "System Error: OrderID not found";
				}
			}
			else
			{
				echo "System Error: OrderID was not provided";
			}
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
