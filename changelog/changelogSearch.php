<?php
	function changelogSearch() {
		if(isset($_POST['search-changelog'])) {
			echo "<div class='form-container-b' id='search-table'>";
			$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
			
			$searchtype = $_POST['search-type'];
			$searchpart = $_POST['search-part'] . "%";
			$searchnum = $_POST['entries'];
			
			if(mysqli_connect_error())
					echo "Connection to database failed: " . mysqli_connect_error();
				
			mysqli_query($conn, "USE" .  "CS3380GRP5");
			
			$result = mysqli_query($conn, "SELECT * FROM Changelog WHERE $searchtype LIKE '$searchpart' LIMIT $searchnum");
			
			if($result == TRUE) {
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
				
				mysqli_close($conn);
				
			}
			else
			{
				echo "No results match your search requirements.";
			}
			echo "</div>";
		}
	}
?>