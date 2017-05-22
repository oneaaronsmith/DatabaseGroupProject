<?php
//This php file is to be used along for "flightEdit.php." It is responsible for creating a table with delete buttons based on a search-delete-show

//Only trigger if user wants to search the table.
if(isset($_POST['show-delete-search-table'])) {
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
	
	if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
	
	//Prepare the search term and "LIKE" component
	$searchpart = $_POST['search-part'] . "%";
	$searchtype = $_POST['search-type'];
	
	mysqli_query($conn, "USE" .  "CS3380GRP5");
	
	//Make the query
	$result = mysqli_query($conn, "SELECT * FROM Flights WHERE $searchtype LIKE '$searchpart'");
		
		//Build the table.
		echo "<table>";
		while($field = mysqli_fetch_field($result))
		{
			echo "<th>";
			echo $field->name . "<br>";
			echo "</th>\n";
		}
		
		echo "<th>Choice</th>";

		while($row = mysqli_fetch_assoc($result))
		{
			echo "<tr>";
				echo "<td>";
				echo $row['flight_number'] . "<br>";
				echo "</td>\n";  
				
				echo "<td>";
				echo $row['departure_city'] . "<br>";
				echo "</td>\n";  
				
				echo "<td>";
				echo $row['arrival_city'] . "<br>";
				echo "</td>\n";  
				
				echo "<td>";
				echo $row['flight_date'] . "<br>";
				echo "</td>\n";  
				
				echo "<td>";
				echo $row['flight_time'] . "<br>";
				echo "</td>\n";  
				
				echo "<td>";
				echo $row['arrival_time'] . "<br>";
				echo "</td>\n";  
			
				echo "<td>";
				echo $row['crew_ID'] . "<br>";
				echo "</td>\n";  
				
				echo "<td>";
				echo $row['aircraft'] . "<br>";
				echo "</td>\n";  
				
				echo "<td>";
				echo $row['price'] . "<br>";
				echo "</td>\n";  
				
				echo "<td>";
				echo $row['monday'] . "<br>";
				echo "</td>\n";
				
				echo "<td>";
				echo $row['tuesday'] . "<br>";
				echo "</td>\n";
				
				echo "<td>";
				echo $row['wednesday'] . "<br>";
				echo "</td>\n";
				
				echo "<td>";
				echo $row['thursday'] . "<br>";
				echo "</td>\n";
				
				echo "<td>";
				echo $row['friday'] . "<br>";
				echo "</td>\n";
				
				echo "<td>";
				echo $row['saturday'] . "<br>";
				echo "</td>\n";
				
				echo "<td>";
				echo $row['sunday'] . "<br>";
				echo "</td>\n";
				
				//Set up the form to pass to flightDelete.php
				echo "<td>";
				echo 	"<form action='flights/flightDelete.php' method='post'>
							<input type='hidden' name='flight_number' value='" . $row['flight_number'] . "'>
							<input type='hidden' name='departure_city' value='" . $row['departure_city'] . "'>
							<input type='hidden' name='arrival_city' value='" . $row['arrival_city'] . "'>
							<input type='hidden' name='flight_date' value='" . $row['flight_date'] . "'>
							<input type='hidden' name='flight_time' value='" . $row['flight_time'] . "'>
							<input type='hidden' name='arrival_time' value='" . $row['arrival_time'] . "'>
							<input type='hidden' name='crew_ID' value='" . $row['crew_ID'] . "'>
							<input type='hidden' name='aircraft' value='" . $row['aircraft'] . "'>
							<input type='hidden' name='price' value='" . $row['price'] . "'>
							<input type='hidden' name='monday' value='" . $row['monday'] . "'>
							<input type='hidden' name='tuesday' value='" . $row['tuesday'] . "'>
							<input type='hidden' name='wednesday' value='" . $row['wednesday'] . "'>
							<input type='hidden' name='thursday' value='" . $row['thursday'] . "'>
							<input type='hidden' name='friday' value='" . $row['friday'] . "'>
							<input type='hidden' name='saturday' value='" . $row['saturday'] . "'>
							<input type='hidden' name='sunday' value='" . $row['sunday'] . "'>
							<input type='submit' name='submit-edit' value='delete'>
						</form>";
				echo "</td>";
				
			echo "</tr>\n";
		}
		
		echo "</table>";
		
		//Give user option to close table.
		echo "<div class='btn btn-primary btn-sm cancel' id='search-delete-show'>Close table</div>";
		mysqli_close($conn);
}
?>