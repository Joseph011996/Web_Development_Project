<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" /> 
		<title>Product List</title>
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
		
		<?php 
			// include some functions from another file.
			include('functions.php');
			
			// if the user provided a search string.
			if(isset($_GET['search']))
			{
				$searchString = $_GET['search'];
			}
			// if the user did NOT provided a search string, assume an empty string
			else
			{
				$searchString = "";
			}

			$SqlSearchString = "%$searchString%";
			
			$safeSearchString = htmlspecialchars($searchString, ENT_QUOTES,"UTF-8");
			//or use 
			//$safeSearchString = makeOutputSafe($searchString);
			
			echo "<form class = 'productsearch'>";
			echo "<input name = 'search' type = 'text' id = 'productname' value = '$safeSearchString' />";
			echo " ";
			echo "<input type = 'submit' id = 'submit' value = 'Search' />";
			echo "  ";
			
			// connect to the database using our function (and enable errors, etc)
			$dbh = connectToDatabase();
			
			if(isset($_GET['SortBy']))
			{
				$sortby = $_GET['SortBy'];
			}
			else
			{
				$sortby = 'Popularity';
			}	
			
			if($sortby == 'A to Z')
			{
				//echo 'A to z';
				//$newsort = 'A to Z';
				$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts
						ON OrderProducts.ProductID = Products.ProductID
						WHERE Products.Description LIKE ?
						GROUP BY Products.ProductID
						ORDER BY Products.Description
						LIMIT 10
						OFFSET ? * 10;');
			}
			elseif($sortby == 'Z to A')
			{
				//echo 'z to a';
				//$newsort = 'Z to A';
				$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts
						ON OrderProducts.ProductID = Products.ProductID
						WHERE Products.Description LIKE ?
						GROUP BY Products.ProductID
						ORDER BY Products.Description DESC
						LIMIT 10
						OFFSET ? * 10;');
			}
			elseif($sortby == 'Low to High')
			{
				//echo 'Low to High';
				//$newsort = 'Low to High';
				$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts
						ON OrderProducts.ProductID = Products.ProductID
						WHERE Products.Description LIKE ?
						GROUP BY Products.ProductID
						ORDER BY Products.Price
						LIMIT 10
						OFFSET ? * 10;');
			}
			elseif($sortby == 'High to Low')
			{
				//echo 'High to Low';
				//$newsort = 'High to Low';
				$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts
						ON OrderProducts.ProductID = Products.ProductID
						WHERE Products.Description LIKE ?
						GROUP BY Products.ProductID
						ORDER BY Products.Price DESC
						LIMIT 10
						OFFSET ? * 10;');
			}else
			{
				//echo 'Popularity';
				//$newsort = 'Popularity';
				$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts
						ON OrderProducts.ProductID = Products.ProductID
						WHERE Products.Description LIKE ?
						GROUP BY Products.ProductID
						ORDER BY COUNT(OrderProducts.ProductID) DESC
						LIMIT 10
						OFFSET ? * 10;');
			}
			
			if(isset($_GET['page']))
			{
				$currentPage = intval($_GET['page']);
			}
			else
			{
				$currentPage = 0;
			}
			
			$previousPage =  $currentPage - 1;
			if ($previousPage >= 0)
			{
				echo "<a href = 'ProductList.php?page=$previousPage&search=$safeSearchString&SortBy=$sortby'>&larr;</a>";
			}
			
			echo "  ";
			echo "<input name = 'page' type = 'number' id = 'pagenumber' value ='$currentPage' />";
			echo "  ";
			
			$nextPage = $currentPage + 1;
			echo "<a href = 'ProductList.php?page=$nextPage&search=$safeSearchString&SortBy=$sortby'>&rarr;</a>";
			
			echo "   ";
			
				echo "<label for ='SortBy'>Sort By: </label>";
				echo "<select name = 'SortBy' id = 'SortBy'>";
					echo "<option value = 'Popularity'>Popularity</option>";
					echo "<option value = 'A to Z'>Name: A to Z</option>";
					echo "<option value = 'Z to A'>Name: Z to A</option>";
					echo "<option value = 'Low to High'>Price: Low to High</option>";
					echo "<option value = 'High to Low'>Price: High to Low</option>";
				echo "</select>";
			echo "</form>";
			
			echo "<br/>";
			
			$statement->bindValue(1,$SqlSearchString); 
			$statement->bindValue(2,$currentPage); 
			
			//execute the SQL.
			$statement->execute();

			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				// Remember that the data in the database could be untrusted data. 
				// so we need to escape the data to make sure its free of evil XSS code.
				$ProductID = htmlspecialchars($row['ProductID'], ENT_QUOTES, 'UTF-8'); 
				$Price = htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8'); 
				$Description = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8'); 
				
				// output the data in a div with a class of 'productBox' we can apply css to this class.
				echo "<div class = 'productBox'>";
				echo "<a href='../Lab07/ViewProduct.php?ProductID=$ProductID'><img src='../IFU_Assets/ProductPictures/$ProductID.jpg' alt ='' /></a>  ";
				echo "$Description <br/>";
				echo "$Price <br/>";
				echo "</div> \n";
				
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