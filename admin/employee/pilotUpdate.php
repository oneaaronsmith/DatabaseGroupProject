<?php
	//This section of php is used alongside "employeeUpdate.php" and displays the pilot's information including all of their employee and pilot specific attributes.
	
	include('../../core/secure/databaseConfig.php');
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
	
	//Announce error if there was an error
	if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
			
	//Select all of the pilot's attributes from both the employee and pilot tables
	$result = mysqli_query($conn, "SELECT Employee.employee_ID,Employee.first_name,Employee.last_name,Employee.email_address,Employee.username,Pilot.status,Pilot.hours,Pilot.rank FROM Employee INNER JOIN Pilot ON Employee.employee_ID = Pilot.employee_ID AND Employee.employee_ID = '" . $id . "'");
		echo "<div class='form-container'>";
			//Make an update form in which the user could change their information, excluding ID and role.
			echo "<form action='employeeUpdate.php' method='post'>";
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
				$id = $row['employee_ID'];
				echo "<tr>";
					echo "
						<td><input type='text' name='id' value='" . 	$row['employee_ID'] . "' readonly></td>
						<td><input type='text' name='fname' value='" . 	$row['first_name'] . "'></td>
						<td><input type='text' name='lname' value='" . 	$row['last_name'] . "'></td>
						<td><input type='text' name='email' value='" . 	$row['email_address'] . "'></td>
						<td><input type='text' name='uname' value='" . 	$row['username'] . "'></td>
						<td><input type='text' name='status' value='" . $row['status'] . "'></td>
						<td><input type='number' name='hours' value='" .$row['hours'] . "'></td>
						<td><input type='text' name='rank' value='" . 	$row['rank'] . "'></td> 
							<input type='hidden' name='role' value='" . $role . "'>
							
						<form action='passwordReset.php' method='post'>
						<td><input type='submit' value='Reset' name='passwordReset' style='width: 150px; background-color: white; border: 0.5px solid #F36D02;'></td>
							<input type='hidden' name='employeeId' value='" . $row['employee_ID'] . "'>
						</form>
						
						</tr>\n";
			}
			echo "</table>";
			mysqli_close($conn);
		
			//Include a button through which the user would submit the form to the employeeUpdate.php
			echo"<br><input type='submit' name='confirm-update' class='btn btn-primary btn-sm' value='Update'>
			</form>";
		echo "</div>";  
		echo "<br><hr>";
?>
	
	<!-- The next section of code deals with the pilot's certifications.-->
	
		<div class="col-xs-1" id='certification'>
			This Pilot's Certifications
			<!-- call php written to display this pilot's certification records -->
			<?php include('displayCertification.php'); 
					displayCertification($id); ?>
		</div>
		
		<div class="col-xs-3" id='planes'>
			Possible Certifications
			<!-- call php written to display the equipment_type table, which includes a list of planes and their attribute -->
			<?php include('../equipment/showEquipmentTypes.php');?>
		</div>
		
		<!-- Create a form for submittimg the certification. It also includes hidden values so that the employee information is still passed through. -->
		<div class="col-xs-8" id='add-certification'>
			Add pilot certification record.
			<pre style='width: 30%; border: 0.5px solid gray;'>
			<form name='add' action='employeeUpdate.php' method='post'>
				Employee ID	<input type='text' name='id' value='<?php echo $id ?>' readonly><br>
				Equipment 	<select name='equipment'>
								<?php include('../form_options/equipmentOptions.php'); ?>
							</select><br>
					<input type='submit' class='btn btn-primary btn-sm' name='add-certification-submit' value='Add Certification Record'>
						<div style='display: none;'>
							<input type='hidden' name='fname' value='<?php echo $fname ?>'>
							<input type='hidden' name='lname' value='<?php echo $lname ?>'>
							<input type='hidden' name='uname' value='<?php echo $uname ?>'>
							<input type='hidden' name='email' value='<?php echo $email ?>'>
							<input type='hidden' name='role' value='<?php echo $role ?>'>
						</div>
			</form>
			</pre>
			<!--Include php for handling addition of employee record addition-->
			<?php include('addCertification.php'); ?>
		</div>
	
		<div class='form-container'>
			<span>If you are finished or do not wish to alter this pilot's information, you may click return</span>
				
			<form action='employeeEdit.php' method='post'>
					<input type='submit' class='btn btn-primary btn-sm cancel' value='Return'>
			</form>
		</div>
				
<?php
	/*This section of php is for handling the confirmation of an update by the user*/
	if(isset($_POST['confirm-update'])) {
	
		//Assign variables.
		$id 	= $_POST['id'];
		$fname 	= $_POST['fname'];
		$lname 	= $_POST['lname'];
		$uname 	= $_POST['uname'];
		$email 	= $_POST['email'];
		$status	= $_POST['status'];
		$hours 	= $_POST['hours'];
		$rank 	= $_POST['rank'];
		
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
			
		mysqli_query($conn, "USE" .  "CS3380GRP5");
		
		//Update the tables with the new information
		$result1 = mysqli_query($conn, "UPDATE Employee SET first_name='$fname',last_name='$lname',username='$uname', email_address='$email' WHERE employee_ID = '$id'");
		$result2 = mysqli_query($conn, "UPDATE Pilot SET status='$status',hours='$hours',rank='$rank' WHERE employee_ID = '$id'");
		if($result1 == TRUE && $result2 == TRUE) {
			//Notify the changelog and print a success message
			$explain = "Administrator updated employee record for employee $id";
			
			include ('../../changelog/recordChange.php');
			record($conn,"Employee Update","Administrator updated personal information of pilot $id");
			echo "<br>Update successful.";
		}
		else if($result1 == TRUE && $result2 == FALSE)
		{
			echo "<br>Basic employee update successful. Pilot attributes update failed to update.";
		}
		else
		{
			echo "<br>Update failed.";
		}
		mysqli_close($conn);
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
					record($conn,"Employee Update","Administrator reset password for pilot $id");
				}
				else {
					echo "Update failed.";
				}		
				
				mysqli_close($conn);
	}
?>