<?php
	//This PHP code is intened to be used alongside "employeeUpdate.php" whenever an attendant is being edited.
	//It allows for the updating of an attendant record
	include('../../core/secure/databaseConfig.php');
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
	
	//Announce error if there was one.
	if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
	
	//Select all employee attributes including attendant specific ones.
	$result = mysqli_query($conn, "SELECT Employee.employee_ID,Employee.first_name,Employee.last_name,Employee.email_address,Employee.username,Attendant.status,Attendant.hours,Attendant.rank FROM Employee INNER JOIN Attendant ON Employee.employee_ID = Attendant.employee_ID AND Employee.employee_ID = '" . $id . "'");
		
		//Create a form for changing the attendant records
		echo "<form id='attendant' action='employeeUpdate.php' method='post'>";
		echo "<br><table>";
		while($field = mysqli_fetch_field($result))
		{
			echo "<th>";
			echo $field->name . "<br>";
			echo "</th>\n";
		}
		echo "<th>Password</th>";
		while($row = mysqli_fetch_assoc($result))
		{
			$rank = $row['rank'];
			echo "<tr>";
				echo "		
					<td><input type='text' name='id' value='" . $row['employee_ID'] . "' readonly></td>
					<td><input onchange='showselected(this.value)' type='text' name='fname' value='" . $row['first_name'] . "'></td>
					<td><input type='text' name='lname' value='" . $row['last_name'] . "'></td>
					<td><input type='text' name='email' value='" . $row['email_address'] . "'></td>
					<td><input type='text' name='uname' value='" . $row['username'] . "'></td>
					<td><input type='text' name='status' value='" . $row['status'] . "'></td>
					<td><input type='number' name='hours' value='" . $row['hours'] . "'></td>
					<td><select name='rank' style='width: 150px; height: 25px;>
							<option value='$rank' selected>$rank</option>
							<option value='Junior'>Junior</option>
							<option value='Senior'>Senior</option>
						</select></td> 
					<input type='hidden' name='role' value='$role'>
						<form action='attendantUpdate.php' method='post'>
						<td><input type='submit' value='Reset' name='passwordReset' style='width: 150px; background-color: white; border: 0.5px solid #F36D02;'></td>
							<input name='employeeId' type='hidden' value='" . $row['employee_ID'] . "'>
						</form>
					</tr>\n";
		}
		echo "</table>";
	
	//Set up a submit for the information.
	echo"<br> <input type='submit' name='confirm-update' class='btn btn-primary btn-sm cancel' value='Update'>
		</form>";
		  
	echo "<br><hr>";
	
	//Let them have a choice to go back.
	echo "If you do not wish change this information, you may return to the previous page";
	
	echo "<form action='employeeEdit.php' method='post'>
			<input type='submit' class='btn btn-primary btn-sm cancel' value='Return'>
		  </form>";

	//If the update is confirmed, this set of code will handle updating both tables simultaneously
	if(isset($_POST['confirm-update'])) {
	
		$id = $_POST['id'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$uname = $_POST['uname'];
		$email = $_POST['email'];
		$status = $_POST['status'];
		$hours = $_POST['hours'];
		$rank = $_POST['rank'];
		
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
			
		mysqli_query($conn, "USE" .  "CS3380GRP5");
		
		//Updates both tables
		$result1 = mysqli_query($conn, "UPDATE Employee SET first_name='$fname',last_name='$lname',username='$uname', email_address='$email' WHERE employee_ID = '$id'");
		$result2 = mysqli_query($conn, "UPDATE Attendant SET status='$status',hours='$hours',rank='$rank' WHERE employee_ID = '$id'");
		if($result1 == TRUE && $result2 == TRUE) {
			//If successful, update the changelog
			$explain = "Changed attendant information for employee $id";
			include('../../changelog/recordChange.php');
			record($conn,"Employee Update","Administrator updated personal information of attendant $id");
			echo "<br>Update successful. Returning to employee edit page in ";
			echo "<span id='timer'>10</span>";
		}
		else if($result1 == TRUE && $result2 == FALSE)
		{
			echo "<script>document.getElementById('attendant').reset();</script>";
			echo "<br>Basic employee update successful. Attendant attributes update failed. Returning to employee edit page in ";
			echo "<span id='timer'>10</span>";

		}
		else
		{
			echo "<br>Update failed. Returning to employee edit page in ";
			echo "<span id='timer'>10</span>";
		}
		
		//There is nothing left to do here, so countdown and leave the page.
		include('countdown.html');
	}
	
	if(isset($_POST['passwordReset'])) {
			
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
					record($conn,"Employee Update","Administrator reset password for attendant $id");
				}
				else {
					echo "Update failed.";
				}	
	}
?>