<?php // <--- do NOT put anything before this PHP tag
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" /> 
		<title>Sign Up!</title>
		<link rel="stylesheet" type="text/css" href="shopstyle.css" />
	</head>
	<body class = "signup">
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
		<div>
			<div class = "SignUpForm">
			<?php
				// display any error messages. TODO style this message so that it is noticeable.
				echo "<div class = 'error_message'>";
				echo $cookieMessage;
				echo "</div>";
			?>
			<h1>Sign Up!</h1>
			<form action = 'AddNewCustomer.php' method = 'POST'>
				<input type = "text" name = "UserName" id = "UserName" placeholder = "UserName" /><br/>
							
				Your Details
				<input type = "text" name = "FirstName" id = "FirstName" placeholder = "First Name" /><br/>
				<input type = "text" name = "LastName" id = "LastName" placeholder = "Last Name" /><br/>
				<input type = "text" name = "Address" id = "Address" placeholder = "Address" /><br/>
				<input type = "text" name = "City" id = "City" placeholder = "City" /><br/>
				<br/>
				<input type = "submit" name = 'SignUp' value = "Register" id="submit" />
			</form>
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