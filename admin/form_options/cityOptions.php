<?php
	//This file is for printing out a list of equipment that can be used.
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
	
	//Announce error if there was an error
	if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
		
	$result = mysqli_query($conn,"SELECT Name,CountryCode FROM City ORDER BY CountryCode");
	
	if($result == TRUE) {
		while($row = mysqli_fetch_assoc($result)) {
				echo "<option value='". $row['Name'] ."'>" . $row['Name'] . ", " . $row['CountryCode'] . "</option>";
		}
	}
	else{
		echo "Could not retrieve city information";
	}
	
	mysqli_close($conn);
?>