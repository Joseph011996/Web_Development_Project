<?php // <--- do NOT put anything before this PHP tag

// this php file will have no HTML

include('functions.php');

if(!isset($_POST['Admin']))
{
	echo "Admin not provided, make sure your form is using POST"; 
}
elseif(!isset($_POST['Password']))
{
	echo "Password not provided"; 
}
else
{
	$Admin = htmlspecialchars($_POST['Admin'], ENT_QUOTES, 'UTF-8');
	$Password = htmlspecialchars($_POST['Password'], ENT_QUOTES, 'UTF-8');

	if($Admin == 'admin' && $Password == 'admin')
	{
		setCookieMessage("Welcome Admin");
		redirect("owner.php");		
	}
	else
	{				
		setCookieMessage("Wrong Credentials! Please enter correct Admin Name and Password");
		redirect("admin.php");
	}
}
