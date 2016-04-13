<?php
	if(! isset($_SESSION['code'])) {

		exit("Direct Script Not Allowed!");

	}

?>
<table class="table">
	<tr>
		<th>Message</th>
		<th>Date Send</th>
		<th>Status</th>
		<th>Operation</th>
	</tr>
<?php
	/*
	* Function Read and Unread
	*/
	function readUnread($convid,$conn) {
	
		
		$select = "SELECT status FROM messages WHERE convID = '$convid' LIMIT 1";
		$select_query = $conn->query($select);
		
		while ($r = $select_query->fetch_assoc()) {
			$status = $r['status'];
		}
		
		if($status == '0') {
			return 'Unread';
		}
		if($status == '1') {
			return 'Read';
		}
	}
	
	
	$select_sent = "SELECT * FROM messages WHERE sender='$username' AND category ='Sent' ORDER BY dateSent DESC";
	
	$q_select_sent = $conn->query($select_sent);
	
	if($q_select_sent->num_rows > 0) {
		
		while($q_row = $q_select_sent->fetch_assoc()) {
		
			echo "<tr>";
			echo "<td>" . mb_substr($q_row['Content'],0,25) . "...</td>";
			echo "<td>" . $q_row['dateSent'] . "</td>";
			echo "<td>" . readUnread($q_row['convID'],$conn) . "</td>";
			echo "<td>";
			echo "<form action='del_sent.php' method='post'>";
			echo "<input type='hidden' name='conv' value='" . $q_row['convID'] . "'/>";
			echo "<input type='submit' value='Delete' class='btn btn-danger'/>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";
		}
	}
	else {
	
		echo "<i>You didn't Send any Message yet.</i>";
	
	}

?>
</table>