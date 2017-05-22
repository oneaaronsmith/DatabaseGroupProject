<?php
	//This function is used for printing Pilots available for a select statement.
	
	function printPilots($i) {
	//This file is for printing out a list of equipment that can be used.
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
	
	//Announce error if there was an error
	if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
		
	$result = mysqli_query($conn,"SELECT employee_ID FROM Employee WHERE Employee.role = 'PILOT'");
	
	if($result == TRUE) {
		//for($i = 0; $i < $numPilots ; $i++) {
		echo "<select name='pilot" . $i . "'>";
		while($row = mysqli_fetch_assoc($result)) {
				echo "<option value='". $row['employee_ID'] ."'>" . $row['employee_ID'] ."</option>";
		}
		echo "</select>";
		//}
	}
	else{
		echo "Could not retrieve pilot information";
	}
	
	mysqli_close($conn);
	
	}
?>