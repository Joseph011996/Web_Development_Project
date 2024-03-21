<?php // <--- do NOT put anything before this PHP tag
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" /> 
		<title>Log In</title>
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
			<h1>Log In!</h1>
			<form action = 'ownerlogin.php' method = 'POST'>
				<input type = "text" name = "Admin" id = "UserName" placeholder = "Admin Name" /><br/>
				<input type = "password" name = "Password" id = "FirstName" placeholder = "*********" /><br/>
				<br/>
				<input type = "submit" name = 'LogIn' value = "Log In" id="submit" />
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