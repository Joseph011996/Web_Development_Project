<?php
	include('functions.php');
	
	if(isset($_POST['commentname'], $_POST['commentmessage']))
	{
		$name = htmlspecialchars($_POST['commentname'], ENT_QUOTES, 'UTF-8');
		$message = htmlspecialchars($_POST['commentmessage'], ENT_QUOTES, 'UTF-8');
		
		$file = fopen("comments.txt", "a");
		fwrite($file,$name);
		fwrite($file," says \n");
		fwrite($file,$message);
		fwrite($file,"\n ------------------- \n");
		fclose($file);
		
		setCookieMessage("Thank you $name for your comment! We value your thoughts.");
		redirect("Homepage.php");
	}
?>