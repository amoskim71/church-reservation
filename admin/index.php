<?php
/*
* Start of Tarlac Cathedral Online Reservation and Scheduling
* Index for Admin Page
*/

/*
* This part of the script will set a session varaible for security purposes
* To avoid direct scripting
*/
	session_start();
	
	$_SESSION['code'] = 1;


/*
* Include the basepath file
* in the constant BASE
*/
	include "basepath.php";


/*
* Page redirection part to login if the admin is not logged in
* 
*/
	if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
		
		if($_SESSION['username'] != 'admin') {

			header ("Location: error_location.php");

		}	
		else {
			// Nothing to do here
		}

	}
	else {

		header ("Location: login.php");

	}


?>


<!DOCTYPE html>
<html class="full" lang="en-US">
<head>
	<title>Admin Panel</title>

<?php
	
	include "includes/head_include.php";

?>

	<!-- Custome Background for Services Offered Page -->
	<link rel="stylesheet" href="../css/background-image.css" />

</head>
<body>
	<div class="container">

		<h1 class="white-text">Admin Pannel</h1>
		
		
		

		<?php
			if(isset($_GET['s']) && $_GET['s'] == 'logout') {
			
			session_destroy();
			
			if($conn) {
				$conn->close();
			}
			
			header("Location: " . $_SERVER['PHP_SELF']);
			
			}
		
			// Include the nav bar for Admin
			require_once "includes/menu.php";
		
		?>
		<div class="row">
			
			<div class="col-md-12">
			
				<?php
				// Display on the day request reservations
				$this_day = date('Y-m-d');
				
				$select_all_reserve = "SELECT * FROM reservation WHERE reserv_date = '$this_day'";
				$select_all_reserve_query = $conn->query($select_all_reserve);
				
				if($select_all_reserve_query->num_rows > 0) {
					
					echo "There are record for today.";
					
				}
				else {
					
					echo "<div class='info-message'>There are no Reservation Requests for today.</div>";
					
				}
				
				?>
			
			</div>
		
		</div>
	</div>


<?php

	require "includes/footer.php";

?>