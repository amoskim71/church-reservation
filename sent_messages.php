<?php
/*
* Sent Messages Page
* 
*/


/*
* This part of the script will set a session varaible for security purposes
* To avoid direct scripting
*/
	session_start();
	
	$_SESSION['code'] = 1;
	
/*
* Include connecton stirng
*/
	include "includes/connect.php";
	

/*
* Condition to check if there's a logined user
*
*/
	if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
		
		$username = $_SESSION['username'];
		
	}
	else {
		
		$username = 'Guest';
		
	}
?>

<!DOCTYPE html>
<html class="full" lang="en-US">
<head>

	<title>Sent Messages - Scheduling and Reservation System for Tarlac San Sebastian Cathedral Parish</title>
	
<?php

	require_once "includes/head_include.php";

?>

	
	<!-- Custom CSS for Background Image for this page -->
	<link rel="stylesheet" href="css/background-image.css" />
	
	
</head>
<body>

	<div class="container">

		<h1 class="text-center white-text">Scheduling and Reservation System for Tarlac San Sebastian Cathedral Parish</h1>
<!-- Start of Navigation -->
<?php
/*
* This will show navigation bar menu if there is signed in user or not
*
*/

	if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
		
		require_once "includes/nav_bar_signed_in.php";
	
	}
	else {
	
		require_once "includes/nav_bar_signed_out.php";
	
	}
?>		
<!--End of Navigation -->

		<div class="messages">
			<h2 class="white-text">Sent Items</h2>
			<p class="white-text"><i><!--Click MessagID to View Messages--></i></p>
			<div class="show-sent">
				<?php
					
					include "includes/show_sent_messages.php";
				
				?>
			</div>
		</div>
			
	</div>
<?php

	include "includes/include_contacts.php";

	require_once "includes/footer.php";

?>