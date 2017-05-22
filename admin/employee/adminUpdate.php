<?php
	//This php file is for use alongside "employeeEdit.php" and is triggered when the user wants to update an ADMIN employee record.
	
	include('../../core/secure/databaseConfig.php');
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
	
	//Announce error if there was an error
	if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
	
	//Make select statement that combines Employee and Admin information.
	$result = mysqli_query($conn, "SELECT Employee.employee_ID,Employee.first_name,Employee.last_name,Employee.email_address,Employee.username FROM Employee INNER JOIN Administrator ON Employee.employee_ID = Administrator.employee_ID AND Employee.employee_ID = '" . $id . "'");
		
		//Print the information.
		echo "<div class='form-container'>";
			echo "<form action='employeeUpdate.php' method='post'>";
			echo "<br><table>";
			while($field = mysqli_fetch_field($result))
			{
				echo "<th>";
				echo $field->name . "<br>";
				echo "</th>\n";
			}
			
			//Print extra header for the password reset choice.
			echo "<th>Password</th>";
			while($row = mysqli_fetch_assoc($result))
			{
				echo "<tr>";
					echo "
						<td><input type='text' name='id' value='" . $row['employee_ID'] . "' readonly></td>
						<td><input type='text' name='fname' value='" . $row['first_name'] . "'></td>
						<td><input type='text' name='lname' value='" . $row['last_name'] . "'></td>
						<td><input type='text' name='email' value='" . $row['email_address'] . "'></td>
						<td><input type='text' name='uname' value='" . $row['username'] . "'></td>
							<input type='hidden' name='role' value='" . $role . "'>
							
						<form action='passwordReset.php' method='post'>
						<td><input type='submit' value='Reset' name='passwordReset' style='width: 150px; background-color: white; border: 0.5px solid #F36D02;'></td>
							<input type='hidden' name='employeeId' value='" . $row['employee_ID'] . "'>
						</form>
						
						</tr>\n";
			}
			echo "</table>";
			
			echo"<br> <input type='submit' name='confirm-update' class='btn btn-primary btn-sm cancel' value='Update'>
				</form>
		</div>";
		
	echo "<br><hr>";
	echo "<div class='form-container'>";
		echo "<h4>If you do not wish to make a change, you may return to the employee edit page</h4>";
		
		echo "<form action='employeeEdit.php' method='post'>
				<input type='submit' class='btn btn-primary btn-sm cancel' value='Return'>
			  </form>";
	echo "</div>";

	
	//Confirm the update and send user back to last page.
	if(isset($_POST['confirm-update'])) {
	
		$id = $_POST['id'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$uname = $_POST['uname'];
		$email = $_POST['email'];
		
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
			
		mysqli_query($conn, "USE" .  "CS3380GRP5");
			
		$result1 = mysqli_query($conn, "UPDATE Employee SET first_name='$fname',last_name='$lname',username='$uname', email_address='$email' WHERE employee_ID = '$id'");
		
		if($result1 == TRUE) {
			include('../../changelog/recordChange.php');
			record($conn,"Employee Update","Administrator updated personal information of administrator $id");
			echo "<br>Update successful. Returning to employee edit page in ";
			echo "<span id='timer'>10</span>";
		}
		else
		{
			echo "<br>Update failed. Returning to employee edit page in ";
			echo "<span id='timer'>10</span>";
		}
		
		include('countdown.html');
	}
	
	if(isset($_POST['passwordReset'])) {
			
			$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
			if(mysqli_connect_error())
				echo "Connection to database failed: " . mysqli_connect_error();
				
			mysqli_query($conn, "USE" .  "CS3380GRP5");
			
			$employee_ID = $_POST['employeeId'];
			
			//Produce a randomized passcode
				$Password = rand();
				
				echo "<br>Please give employee $employee_ID their new login information. Their new password is $Password<br>";
				
				//Encrypt password.
				$Password = hash("sha256",$Password);
				$Password = hash("sha512",$Password);
				
				//Insert encrypted password into the Authentication table.
				if($passwordstmt = mysqli_prepare($conn, "UPDATE Authentication SET password=? WHERE employee_ID=?")) {
					mysqli_stmt_bind_param($passwordstmt,'si',$Password,$employee_ID);
					mysqli_stmt_execute($passwordstmt);
					mysqli_stmt_close($passwordstmt);
					
					include('../../changelog/recordChange.php');
					record($conn,"Employee Update","Administrator reset password for admin $id");
				}
				else {
					echo "Update failed.";
				}		
				mysqli_close($conn);
	}
?>