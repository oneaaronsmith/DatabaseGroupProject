<?php
	//This php file is for use alongside employeeEdit.php. It triggers whenever the user decides to add an employee to the database.
	if(isset($_POST['add-submit']))
	{	
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		//Retrieve desired employee data
		$fname = $_POST['first_name'];
		$lname = $_POST['last_name'];
		$uname = $_POST['user_name'];
		$email = $_POST['email'];
		$role = $_POST['role'];
		
		if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
		
		mysqli_query($conn, "USE" .  "CS3380GRP5");
		
		//Set up prepare statement to make query. And then run statement.
		if($stmt = mysqli_prepare($conn, "INSERT INTO Employee (first_name,last_name,email_address,username,role) VALUES (?,?,?,?,?)")) {
			mysqli_stmt_bind_param($stmt,'sssss', $fname,$lname,$email,$uname,$role);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			
			//Get the employee ID from the database through an assigned auto_increment
			$result = mysqli_query($conn,"SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'CS3380GRP5' AND TABLE_NAME = 'Employee'");
			
			//If the ID was successfully retrieved, determine what type of employee they were and give the tables initial data.
			if($result == TRUE){
				$row = mysqli_fetch_assoc($result);
				$id = $row['AUTO_INCREMENT'] - 1;
				
				//Insert information to the sub entity tables dependent on employee type (They are set with default values to be lowest rank and zero hours in SQL).
				switch ($role) {
					case 'ADMIN': 
						if($adminstmt = mysqli_prepare($conn, "INSERT INTO Administrator (employee_ID) VALUES (?)")) {
							mysqli_stmt_bind_param($adminstmt,'i',$id);
							mysqli_stmt_execute($adminstmt);
							mysqli_stmt_close($adminstmt);
						}
						break;
					case 'PILOT':
						if($pilotstmt = mysqli_prepare($conn, "INSERT INTO Pilot (employee_ID) VALUES (?)")) {
							mysqli_stmt_bind_param($pilotstmt,'i',$id);
							mysqli_stmt_execute($pilotstmt);
							mysqli_stmt_close($pilotstmt);
						}
						break;
					case 'ATTENDANT':
						if($attendstmt = mysqli_prepare($conn, "INSERT INTO Attendant (employee_ID) VALUES (?)")) {
							mysqli_stmt_bind_param($attendstmt,'i',$id);
							mysqli_stmt_execute($attendstmt);
							mysqli_stmt_close($attendstmt);
						}
						break;
					default:
						echo "Not a valid employee type";
						break;
				}
				
				//Produce a randomized passcode
				$firstPassword = rand();
				
				echo "<br>Please give the new employee their first login information. Their ID is $id and password is $firstPassword<br>";
				echo "<br>A new password can be produced through the employee update page.<br>";
				
				//Encrypt password.
				$firstPassword = hash("sha256",$firstPassword);
				$firstPassword = hash("sha512",$firstPassword);
				
				//Insert encrypted password into the Authentication table.
				if($passwordstmt = mysqli_prepare($conn, "INSERT INTO Authentication (employee_ID, password, role) VALUES (?,?,?)")) {
					mysqli_stmt_bind_param($passwordstmt,'iss',$id,$firstPassword,$role);
					mysqli_stmt_execute($passwordstmt);
					mysqli_stmt_close($passwordstmt);
				}
			}
			
			//Log the change. The record function takes in the connection, the type of action, and an explanation of the action.
			include('../../changelog/recordChange.php');
			record($conn,"Employee Addition","Added employee " . $id . " named " . $fname . " " . $lname);
		}
		else
		{
			//Notify user if insertion failed
			echo "The addition failed.";
		}
		
		//Use another prepare to notify user on what was inserted
		if($stmt = mysqli_prepare($conn, "SELECT * FROM Employee WHERE employee_ID=?")) {
			mysqli_stmt_bind_param($stmt,'s',$id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$col1,$col2,$col3,$col4,$col5,$col6);
			
			//fetch and print results
			if(mysqli_stmt_fetch($stmt)) {
				echo "<br><div>";
				printf("\nThe new record for %s %s was added successfully\n",$col2,$col3);
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