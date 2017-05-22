<?php
	//This php code is for use with "pilotUpdate.php". It can update the Certification table with new certification records.
	//It is triggered when an admin user clicks the 'add-certification-submit' input on the pilot update page.
	
	if(isset($_POST['add-certification-submit'])) {
		$id = $_POST['id'];
		$equipment = $_POST['equipment'];
		
		
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		//Announce error if there was an error
		if(mysqli_connect_error())
				echo "Connection to database failed: " . mysqli_connect_error();
		
		mysqli_query($conn, "USE" .  "CS3380GRP5");
		
		$existence = mysqli_query($conn,"SELECT employee_ID FROM Certification WHERE employee_ID='". $id ."' AND equipment='" . $equipment ."'");
		$trigger = mysqli_num_rows($existence);
		
		if($trigger == 0) {
			//Set up prepare statement
			if($stmt = mysqli_prepare($conn, "INSERT INTO Certification (employee_ID,equipment) VALUES (?,?)")) {
				
				//bind parameters
				mysqli_stmt_bind_param($stmt,'is', $id,$equipment);
				
				//execute statement
				mysqli_stmt_execute($stmt);
				
				//close statement
				mysqli_stmt_close($stmt);
			
				//Set up a confirmation statement
				if($stmt = mysqli_prepare($conn, "SELECT * FROM Certification WHERE employee_ID=? AND equipment=?")) {
						mysqli_stmt_bind_param($stmt,'is',$id,$equipment);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt,$col1,$col2);
						
						//fetch and print results
						if(mysqli_stmt_fetch($stmt)) {
							echo "<br><div>";
							printf("\nA new certification for employee %s and equipment type %s was added successfully\n",$col1,$col2);
							echo ("<br>To show in certificate table, refresh the page");
							echo "</div><br>";
						}
						mysqli_stmt_close($stmt);
					}
					
					//Update the changelog
					include('../../changelog/recordChange.php');
					record($conn,"Certification","Administrator added $equipment certification for employee $id");
			}
			else
			{
				echo "Certification failed.";
			}
		}
		else {
				//If there is already a certification in the database, let the user know that they messed up bad.
				echo "Certification already exists.";
		}
		mysqli_close($conn);
	}
?>

<!--WHERE NOT EXISTS(SELECT * FROM Certification WHERE employee_ID=? AND equipment=?)-->