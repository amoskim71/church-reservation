<?php
/*
* Start of Tarlac Cathedral Online Reservation and Scheduling
* 
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
* include connection string
*/
	include "includes/connect.php";

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

	if(isset($_POST['name']) && !empty($_POST['name'])) {
	
		$name = $_POST['name'];
		$sched = $_POST['sched'];
		
		$add_priest = "INSERT INTO priests (name, sched, dateCreated)
			VALUES ('$name','$sched',NOW())";
			
		$add_priest_query = $conn->query($add_priest);
		
		if($add_priest_query) {
		
			$p_msg = "<div class='alert alert-info text-center'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				Priest Added!</div>";
			
		}
	
	}

?>


<!DOCTYPE html>
<html class="full" lang="en-US">
<head>
	<title>Priests Panel</title>

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
			
			<div class="col-md-7">
			<?php echo @$p_msg; ?>
			<div class="center-div">
				<h2 class='white-text'>Add Priest Info</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
					<label>Name:</label>
					<input type="text" class="form-control" id="name" name="name"
						required autofocus placeholder="Name of Priest"/>
					<br/>
					<label>Schedule:</label>
					<input type="text" class="form-control" id="sched" name="sched" placeholder="Schedule of the Priest" required />
					<br/>
					<input type="submit" class="btn btn-primary" value="Save" />
					&nbsp;&nbsp;
					<input type="reset" class="btn btn-danger" value="Clear" />
				</form>
				
			</div>
			</div>
		</div>
	</div>


<?php

	require "includes/footer.php";

?>