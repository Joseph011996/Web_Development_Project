<?php // <--- do NOT put anything before this PHP tag

include('functions.php');

// Did the user click the buy button AND did they provide a ProductID?
if(!isset($_POST['BuyButton']))
{
	echo "BuyButton not provided, the submit button should be named BuyButton and the form method should be POST"; 
}
elseif(!isset($_GET['ProductID']))
{
	echo "ProductID not provided, make sure you have passed the ProductID in the URL"; 
}
else 
{
	$productToBuy = trim($_GET['ProductID']);
	//print_r($productToBuy);
	// add the product to the shopping cart cookie
	// if the cookie is defined AND not an empty string
	if(isset($_COOKIE['ShoppingCart']) && $_COOKIE['ShoppingCart'] != "")
	{
		// TODO: Get the list of items in the shopping cart.
		// and then add the $productToBuy to the end of the comma separated list.
		$ShoppingList = $_COOKIE['ShoppingCart'];
		
		$newList = "$ShoppingList,$productToBuy";
		setcookie("ShoppingCart", $newList);
		
		// --> you may want to check lecture 14. <--
		
		// TODO: set the "ShoppingCart" cookie (notice the capital letters).
		// setcookie(...);
	}
	else 
	{
		// add this producuID to the shopping cart.
		// because this is the first item in the cart no commas are required.
		setcookie("ShoppingCart", $productToBuy);
		// TODO: set the "ShoppingCart" cookie (notice the capital letters).
		// setcookie(...);
	}
	//print_r($_COOKIE);
	// redirect the user back to ViewProduct.php 
	redirect("ViewProduct.php?ProductID=$productToBuy");
}
