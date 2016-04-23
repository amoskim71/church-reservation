<?php


/*
* This part of the script will set a session varaible for security purposes
* To avoid direct scripting
*/
	session_start();
	
	$_SESSION['code'] = 1;
	
	

/*
* Check if session username or name of the logged in user isset
* if not Guest User 
*/

	if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
		
		$username = $_SESSION['username'];;
		
		
	}
	else {
		$username = "Guest";
		header("Location: index.php");
	}


/*
* The Connection String
*
*/

	require_once "includes/connect.php";
	
	
	if(isset($_POST['eventtype']) && !empty($_POST['eventtype'])) {
		
		// Select Time
		$event_time = $_POST['timeselect'];
	
		// Event Select
		$event = $_POST['eventtype'];
		
		// Baptism Type Select
		$bap_type = $_POST['bap-type'];
		
		// Baptism Time Select Depending on Baptism Type
		if($event == 'Baptism') {
			
			if($bap_type == 'Ordinary') {
				$event_time = "5";
				$event = "Ordinary Baptism";
			}
			
		}
		
		// Date Setting
		if($_POST['dateselect'] != '') {
			$event_date = date('y-m-d', strtotime($_POST['dateselect']));
		}
		if($_POST['dateselect2'] != '') {
		
			$event_date = date('y-m-d', strtotime($_POST['dateselect2']));
		
		}
		if($_POST['dateselect3'] != '') {
		
			$event_date = date('y-m-d', strtotime($_POST['dateselect3']));
		
		}
		
/*
* Function to convert Number values of Time to Time Slots
* Calling this function to convert certain values to time value
* num_to_time()
*/
		
		function num_to_time($val) {
			
			if($val == 1) {
				$val = "8:00am";
			}
			else if ($val == 2) {
				$val = "9:00am";
			}
			else if ($val == 3) {
				$val = "10:00am";
			}
			else if ($val == 4) {
				$val = "11:00am";
			}
			else if ($val == 5) {
				$val = "12:00pm";
			}
			else if ($val == 6) {
				$val = "1:00pm";
			}
			else if ($val ==7) {
				$val = "2:00pm";
			}
			else if ($val == 8) {
				$val = "3:00pm";
			}
			else if ($val == 9) {
				$val = "4:00pm";
			}
			else if ($val == 10) {
				$val = "5:00pm";
			}
			
			return $val;
			
		}

	// Function that converts php date to word
	function dateName($date) {
		
		$result = "";
		
		$convert_date = strtotime($date);
		$month = date('F',$convert_date);
		$year = date('Y',$convert_date);
		$name_day = date('l',$convert_date);
		$day = date('j',$convert_date);
		
		
		$result = $month . " " . $day . ", " . $year . " - " . $name_day;
		
		return $result;
	}
		
		
		// Reserve Number Generator
		// Reference Number Serve as alternative ID for the
		// reserved schedule
		function generateRandomString($length = 10) {
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		// Getting The Ramdom Number Generated
		$reserv_num = generateRandomString();
		
		// Getting the Priest
		$priest = $_POST['priest'];
		if($priest == "") {
			$priest = "Any";
		}

		
		// Event Time for Confirmation
		if ($event == 'Confirmation') {
			$event_time = '2';
		}
		
		if($event == 'Wedding') {
			
			$time = $_POST['timeselect2'];
			
			if($time == '1') {
				$event_time = '1';
			}
			else if ($time == '6') {
				$event_time = '6';
			}
			
		}
		
		
	}
	
	
	if(isset($_POST['event']) && !empty($_POST['event'])) {
		
		$event = $_POST['event'];
		$edate = date('y-m-d', strtotime($_POST['edate']));
		$priest = $_POST['priest'];
		$etime = $_POST['etime'];
		$rn = $_POST['rn'];
		
		// Search or Select for Active reservation for a user
		// if there are active reservation for an event, 
		// the user will not be able to resreve another
		$select_user_events = "SELECT * FROM reservation WHERE username = '$username' AND event_type = '$event' AND status = 'Active' AND reserv_date >= CURRENT_DATE()";
		$select_user_events_query = $conn -> query($select_user_events);
			
		if($select_user_events_query->num_rows > 0) {
				
			echo "<script>alert('You have another pending reservation on this event!');";
			echo "window.location.href = 'reservation.php';</script>";
			
		}
		else {
			
			// Search for Conflict on the event they are trying to reserve
			// If there are similar record that the users are trying to reserve
			// the system will automatically prevent it, to avoid conflict in reserved schedules
			$search_record = "SELECT * FROM reservation WHERE reserv_date='$edate' AND reserv_time='$etime'";
			$srq = $conn->query($search_record);
		
			if($srq->num_rows > 0) {
				
				echo "<script>alert('The Date and Time is already reserved.')</script>";
				
			}
			else {
		
				$greater_to_ten = "SELECT * FROM reservation WHERE reserv_date = '$edate'";
		
			// Start of Adding Reservation
			// Start of Adding Reservation
			$reservation = "INSERT INTO reservation (reserv_num, event_type, priest, reserv_date, reserv_time, username, status, confirmation, date_reserved)
				VALUES(
					'$rn',
					'$event',
					'$priest',
					'$edate',
					'$etime',
					'$username',
					'Active',
					'NC',
					NOW()
				)";
			$reservation_query = $conn->query($reservation);
			if($reservation_query == true) {
				echo "<script>alert('Reservation Saved For Approving by the Admin');";
				echo "window.location.href = 'reservation.php';</script>";
			}// End of Adding Reservation
			// End of Adding Reservation
			
			}
		}
		
	}
	

?>


<!DOCTYPE html>
<html class="full" lang="en-US">
<head>
	<title>Scheduling and Reservation System for Tarlac San Sebastian Cathedral Parish</title>
	
<?php
/*
* This will include the commond includes in head section of every page
* 
*/
	require "includes/head_include.php";
	
?>
	
	<!-- Custom CSS for Background Image for this page -->
	<link rel="stylesheet" href="css/background-image.css" />
	

</head>
<body>

	<div class="container">
	
		<h1 class="white-text">Summary of Reservation</h1>
		
		<div class="center-div">
		
			<h2 class="white-text"><?php echo "Event: " . @$event; ?></h2>
			<h2 class="white-text"><?php echo "Date: " . @dateName($event_date); ?></h2>
			<h2 class="white-text"><?php echo "Priest: " . @$priest; ?></h2>
			<h2 class="white-text"><?php echo "Time: " . @num_to_time($event_time); ?></h2>
		
			<table border='0'>
			<tr>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			
				<input type="hidden" name="event" value="<?php echo $event; ?>" />
				<input type="hidden" name="edate" value="<?php echo $event_date; ?>" />
				<input type="hidden" name="priest" value="<?php echo $priest; ?>" />
				<input type="hidden" name="etime" value="<?php echo $event_time; ?>" />
				<input type="hidden" name="rn" value="<?php echo $reserv_num; ?>" />
				<td>
				<input type="submit" value="Continue" class="btn-lg btn-primary" />
				</td>
			</form>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<form action="reservation.php" method="post">
			
				<input type="hidden" name="event" value="<?php echo $event; ?>" />
				<input type="hidden" name="edate" value="<?php echo $event_date; ?>" />
				<input type="hidden" name="priest" value="<?php echo $priest; ?>" />
				<input type="hidden" name="etime" value="<?php echo $event_time; ?>" style="float: left;"/>
				<td>
				<input type="submit" value="Change" class="btn-lg btn-success" style="float: left;"/>
				</td>
			</form>
			</tr>
			</table>
				
		</div>
	
	</div>
		
<?php
	include "includes/include_contacts.php";

/*
* This part will include the footer script.
* Required in every pages of the website
*/
	require "includes/footer.php";

?>