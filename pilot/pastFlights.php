<?php
include_once('../core/secure/databaseConfig.php');
	function showFlightTable() {
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);

	//Announce error if there was one.
	if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();

	//Choose the group database
	mysqli_query($conn, "USE" .  "CS3380GRP5");

	//Make the query, bind params.
	$stmt = mysqli_prepare($conn, 'SELECT Flights.flight_number AS Flight, Flights.departure_city AS Departs, Flights.arrival_City AS Arrives, Flights.flight_date AS Day, Flights.flight_time AS Departs, Flights.arrival_time AS Arrives, Flights.aircraft AS Aircraft FROM Flights INNER JOIN Crew ON Crew.crew_ID=Flights.crew_ID WHERE Crew.employee_ID=?');

	mysqli_stmt_bind_param($stmt, 's', $_COOKIE['employeeId']);
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

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

	}

	showFlightTable();
?>
