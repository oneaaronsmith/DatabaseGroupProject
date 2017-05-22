<?php
	function showEquipmentTableDelete() {
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		if(mysqli_connect_error())
				echo "Connection to database failed: " . mysqli_connect_error();
			
		mysqli_query($conn, "USE" .  "CS3380GRP5");
			
		$result = mysqli_query($conn, "SELECT equipment,serial_num FROM Equipment");
			
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
					echo $row['equipment'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['serial_num'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo 	"<form action='equipment/equipmentDelete.php' method='post'>
								<input type='hidden' name='equipment' value='" . $row['equipment'] . "'>
								<input type='hidden' name='serial_num' value='" . $row['serial_num'] . "'>
								<input type='submit' name='submit-edit' value='delete'>
							</form>";
					echo "</td>";
					
				echo "</tr>\n";
			}
			
			echo "</table>";
			
			mysqli_close($conn);
	}
?>