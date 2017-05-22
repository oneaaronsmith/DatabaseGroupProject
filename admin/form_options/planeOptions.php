<?php
	//This file is for printing out a list of equipment that can be used.
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
	
	//Announce error if there was an error
	if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
		
	//For their reference.
	$resultA = mysqli_query($conn,"SELECT Equipment.equipment,Equipment.serial_num,Equipment_type.description,Equipment_type.seats,
	Equipment_type.pilots_required,Equipment_type.attendants_required FROM Equipment INNER JOIN Equipment_type ON Equipment.equipment = Equipment_type.equipment");
	
	if($resultA == TRUE) {
		//Begin table
		echo "Planes available";
		echo "<table>";
		
		//Include headers
		while($field = mysqli_fetch_field($resultA))
		{
			echo "<th>";
			echo $field->name . "<br>";
			echo "</th>\n";
		}
		
		//Include table data
		while($row = mysqli_fetch_row($resultA))
		{
			echo "<tr>";
			foreach($row as $value)
			{
				echo "<td>";
				echo $value . "<br>";
				echo "</td>\n";  
			}
			echo "</tr>\n";
		}
		
		//Close the table
		echo "</table>";
	}
		
	//Okay, now that they know whats there.
	$result = mysqli_query($conn,"SELECT serial_num FROM Equipment");
	
	if($result == TRUE) {
		echo "<br><h5>Plane Choice:</h4> <select name='aircraft'>";
		while($row = mysqli_fetch_assoc($result)) {
				echo "<option value='". $row['serial_num'] ."'>" . $row['serial_num'] ."</option>";
		}
		echo "</select>";
	}
	
	mysqli_close($conn);
?>