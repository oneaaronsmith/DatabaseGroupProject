<?php
	//Connect to database
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
	
	//Announce error if there was one.
	if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
		
	//Choose the group database
	mysqli_query($conn, "USE" .  "CS3380GRP5");
		
	//Make the query
	$result = mysqli_query($conn, "SELECT Employee.employee_ID,Employee.role,Crew.crew_ID FROM Crew INNER JOIN Employee ON Employee.employee_ID = Crew.employee_ID ORDER BY crew_ID,role");
	
	//Begin table
	echo "<table>";
	
	//Include headers
	while($field = mysqli_fetch_field($result))
	{
		echo "<th>";
		echo $field->name . "<br>";
		echo "</th>\n";
	}
	
	//Include table data
	while($row = mysqli_fetch_row($result))
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

	//Close the connection
	mysqli_close($conn);
?>