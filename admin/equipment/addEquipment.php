<?php
	if(isset($_POST['add-submit']))
	{	
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		//date_default_timezone_set('UTC');
		
		//Retrieve employee data
		$equipment = $_POST['equipment'];
		$num = $_POST['serial'];
		
		if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
		
		mysqli_query($conn, "USE" .  "CS3380GRP5");
		
		//Set up prepare statement
		if($stmt = mysqli_prepare($conn, "INSERT INTO Equipment (equipment,serial_num) VALUES (?,?)")) {
			
			//bind parameters
			mysqli_stmt_bind_param($stmt,'ss', $equipment,$num);
			
			//execute statement
			mysqli_stmt_execute($stmt);
			
			//close statement
			mysqli_stmt_close($stmt);
			
			//Log the change
			//Prepare the changelog message.
			include('../changelog/recordChange.php');
			record($conn,"Add Equipment","Administrator added equipment " . $equipment . " with serial number " . $num);
		}
		else
		{
			//Notify user if insertion failed
			echo "The addition failed.";
		}
		
		//Use another prepare to notify user on what was inserted
		if($stmt = mysqli_prepare($conn, "SELECT * FROM Equipment WHERE serial_num=?")) {
			mysqli_stmt_bind_param($stmt,'s',$num);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$col1,$col2);
			
			//fetch and print results
			if(mysqli_stmt_fetch($stmt)) {
				echo "<br><div>";
				printf("\nA new record for %s %s was added successfully\n",$col1,$col2);
				echo "</div><br>";
			}
			mysqli_stmt_close($stmt);
		}
		else
		{
			echo "Could not confirm insertion";
		}
		
		mysqli_close($conn);
	}
?>