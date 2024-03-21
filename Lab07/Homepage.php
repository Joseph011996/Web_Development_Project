<?php // <--- do NOT put anything before this PHP tag
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" /> 
		<title>Welcome to ZAP</title>
		<link rel="stylesheet" type="text/css" href="shopstyle.css" />
	</head>
	<body>
		<header>
		<div class = "logo">
			<img src = "images/logo1.jpg" alt = "ZAP Logo" />
		</div>		
		
		<nav class = "navbar home">
			<ul>
			  <li><a href="Homepage.php">Home</a></li>
			  <li><a href="ProductList.php">Products</a></li>
			  <li><a href="ViewCart.php">View Cart</a></li>
			  <li><a href="CustomerList.php">Customers</a></li>
			  <li><a href="OrderList.php">Orders</a></li>
			  <li><a href="SignUp.php">Sign Up</a></li>
			  <li><a href="admin.php">Admin</a></li>
			</ul>
		
			<form class = "searchbar" action = "ProductList.php" method = "GET"> 
				<input type = 'text' name = 'search'  id = "searchproduct" placeholder = "Search Item"/> 
				<input type = 'submit' value = 'Search' id = "submit" /> 
			</form>
		</nav>
		</header>
		<div class = "pagecontent">
		<?php
			echo "<div class = 'message'>";
			echo $cookieMessage;
			echo "</div>";
			
			$dbh = connectToDatabase();
			
			echo "<div class = 'hometop'>";
				echo "<div id='sliderImages'>";
				echo "<img src='images/banner1.jpg' alt ='' />";
				echo "<img src='images/banner2.jpg' alt ='' />";
				echo "<img src='images/banner3.jpg' alt ='' />";
				echo "<img src='images/banner4.jpg' alt ='' />";
				echo "<img src='images/banner5.jpg' alt ='' />";
				echo "</div>";
			echo "</div>";
			echo "<div class = 'homecenter'>";
				echo "<div id = 'leftcenter'>";
					echo "<b>Best Sellers</b>";
				echo "</div>";
				echo "<div id = 'rightcenter'>";	
					echo "<b>Best Selling Brands</b>";
				echo "</div>";
			echo "</div>";
			echo "<div class = 'homebottom'>";
				//querying the 3 most popular items. 
				echo "<div class = 'mostpopular1'>";
					$statement1 = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts
									ON OrderProducts.ProductID = Products.ProductID
									GROUP BY Products.ProductID
									ORDER BY COUNT(OrderProducts.ProductID) DESC
									LIMIT 1;');
									
					$statement1->execute();
				
					while($row = $statement1->fetch(PDO::FETCH_ASSOC))
					{
						$ProductID = htmlspecialchars($row['ProductID'], ENT_QUOTES, 'UTF-8');
						echo "<a href='ViewProduct.php?ProductID=$ProductID'><img src='../IFU_Assets/ProductPictures/$ProductID.jpg' alt ='' /></a>";
					}
				echo "</div>";
				echo "<div class = 'mostpopular2'>";
					$statement2 = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts
									ON OrderProducts.ProductID = Products.ProductID
									GROUP BY Products.ProductID
									ORDER BY COUNT(OrderProducts.ProductID) DESC
									LIMIT 1
									OFFSET 1;');
									
					$statement2->execute();
				
					while($row = $statement2->fetch(PDO::FETCH_ASSOC))
					{
						$ProductID = htmlspecialchars($row['ProductID'], ENT_QUOTES, 'UTF-8');
						echo "<a href='ViewProduct.php?ProductID=$ProductID'><img src='../IFU_Assets/ProductPictures/$ProductID.jpg' alt ='' /></a>";
					}
				echo "</div>";
				echo "<div class = 'mostpopular3'>";
					$statement3 = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts
									ON OrderProducts.ProductID = Products.ProductID
									GROUP BY Products.ProductID
									ORDER BY COUNT(OrderProducts.ProductID) DESC
									LIMIT 1
									OFFSET 2;');
									
					$statement3->execute();
				
					while($row = $statement3->fetch(PDO::FETCH_ASSOC))
					{
						$ProductID = htmlspecialchars($row['ProductID'], ENT_QUOTES, 'UTF-8');
						echo "<a href='ViewProduct.php?ProductID=$ProductID'><img src='../IFU_Assets/ProductPictures/$ProductID.jpg' alt ='' /></a>";
					}
				echo "</div>";
				
				//querying the 3 most popular brands.
				echo "<div class = 'brandpopular1'>";
					$statement4 = $dbh->prepare('SELECT *
									FROM Products LEFT JOIN OrderProducts
									ON OrderProducts.ProductID = Products.ProductID
									LEFT JOIN Brands
									ON Products.BrandID = Brands.BrandID
									GROUP BY Products.BrandID
									ORDER BY COUNT(*) DESC
									LIMIT 1;');
									
					$statement4->execute();
				
					while($row = $statement4->fetch(PDO::FETCH_ASSOC))
					{
						$BrandID = htmlspecialchars($row['BrandID'], ENT_QUOTES, 'UTF-8');
						$BrandName = htmlspecialchars($row['BrandName'], ENT_QUOTES, 'UTF-8');
						
						echo "<a href='ProductList.php?search=$BrandName'><img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID' /></a>";
					}
				echo "</div>";
				echo "<div class = 'brandpopular2'>";
					$statement5 = $dbh->prepare('SELECT *
									FROM Products LEFT JOIN OrderProducts
									ON OrderProducts.ProductID = Products.ProductID
									LEFT JOIN Brands
									ON Products.BrandID = Brands.BrandID
									GROUP BY Products.BrandID
									ORDER BY COUNT(*) DESC
									LIMIT 1
									OFFSET 1;');
									
					$statement5->execute();
				
					while($row = $statement5->fetch(PDO::FETCH_ASSOC))
					{
						$BrandID = htmlspecialchars($row['BrandID'], ENT_QUOTES, 'UTF-8');
						$BrandName = htmlspecialchars($row['BrandName'], ENT_QUOTES, 'UTF-8');
						
						echo "<a href='ProductList.php?search=$BrandName'><img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID' /></a>";
					}
				echo "</div>";
				echo "<div class = 'brandpopular3'>";
					$statement6 = $dbh->prepare('SELECT *
									FROM Products LEFT JOIN OrderProducts
									ON OrderProducts.ProductID = Products.ProductID
									LEFT JOIN Brands
									ON Products.BrandID = Brands.BrandID
									GROUP BY Products.BrandID
									ORDER BY COUNT(*) DESC
									LIMIT 1
									OFFSET 2;');
									
					$statement6->execute();
				
					while($row = $statement6->fetch(PDO::FETCH_ASSOC))
					{
						$BrandID = htmlspecialchars($row['BrandID'], ENT_QUOTES, 'UTF-8');
						$BrandName = htmlspecialchars($row['BrandName'], ENT_QUOTES, 'UTF-8');
						
						echo "<a href='ProductList.php?search=$BrandName'><img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID' /></a>";
					}
				echo "</div>";
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