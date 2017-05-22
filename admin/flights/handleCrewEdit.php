<?php

	//These functions are for use with crewEdit.php to print select statements for each pilot and attendant.
	
	//printCrewChoices works with pilotOptions.php and attendantOptions.php to create select statements through which the user can choose employees.
	//The added space in the echo makes the pre look better.
	function printCrewChoices($numPilots,$numAttendants) {
		include('../form_options/pilotOptions.php');
		
		echo "<pre>";
		for($i = 0 ; $i < $numPilots ; $i++) {
					//By trial and error, fire and flames, I made the pre look good with spaces.
					echo "					Pilot ID:	"; 
					printPilots($i);
					echo "<br>";
		}
		
		include('../form_options/attendantOptions.php');
		
		for($j = 0 ; $j < $numAttendants ; $j++) {
				
					echo "					Attendant ID:	"; 
					printAttendants($j);
					echo "<br>";
		}
		echo "					Crew Number:";
		echo "<input type='hidden' name='numPilots' value='$numPilots'>
					<input type='hidden' name='numAttendants' value='$numAttendants'>";
		
		//Echo a button for submitting.
		echo "<input type='number' value='Crew Id' name='crewId'><br>";
		echo "<div class='form-container'><input type='submit' class='btn btn-primary btn-sm' value='Submit Crew' name='crewSubmit'></div>";
		echo "</pre>";
	}
	
	//This function builds a new crew using the number of pilots and attendants and a post from crewEdit.php
	function newCrew($numPilots,$numAttendants,$crew) {
		include('../../changelog/recordChange.php');
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		$i = 0;
		$j = 0;
		
		$pilot = array();
		
		$attendant = array();
		
		for ($i = 0; $i < $numPilots ; $i++) {
		$currentPilot = "pilot" . $i;
		$pilotCurrent = $_POST[$currentPilot];
		array_push($pilot, $pilotCurrent);
		}
		
		for ($j = 0; $j < $numAttendants ; $j++) {
		$currentAttendant = "attendant" . $j;
		array_push($attendant, $_POST[$currentAttendant]);
		}
		
		for($i = 0; $i < $numPilots ; $i++)
		{
			for($j = $i+1; $j < $numPilots ; $j++) {
				if($pilot[$i] == $pilot[$j]) {
					echo "Error, you cannot insert the same employee twice.";
					return;
				}
			}
		}
		
		for($i = 0; $i < $numAttendants ; $i++)
		{
			for($j = $i+1; $j < $numAttendants ; $j++) {
				if($attendant[$i] == $attendant[$j]) {
					echo "Error, you cannot insert the same employee twice. That's double jeopardy. Unconstitutional.";
					return;
				}
			}
		}
		
		foreach ( $pilot as $employee_ID )
		{
			$role = 'PILOT';
			
			if($stmt = mysqli_prepare($conn, "INSERT INTO Crew (employee_ID,crew_ID,role) VALUES (?,?,?) ")) {
				mysqli_stmt_bind_param($stmt,'iis',$employee_ID,$crew,$role);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
				
				record($conn,"Add to Crew","Admin added pilot $employee_ID to crew $crew");
			}
			else {
				echo "Failed to add pilots";
			}
		}
		
		foreach ( $attendant as $employee_ID )
		{
			$role = 'ATTENDANT';
			
			if($stmt = mysqli_prepare($conn, "INSERT INTO Crew (employee_ID,crew_ID,role) VALUES (?,?,?) ")) {
				mysqli_stmt_bind_param($stmt,'iis',$employee_ID,$crew,$role);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
				
				record($conn,"Add to Crew","Admin added attendant $employee_ID to crew $crew");
			}
			else {
				echo "Failed to add attendants";
			}
		}
		
		mysqli_close($conn);
	}
	
	function deleteCrew($crew) {
		include('../../changelog/recordChange.php');
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		$result = mysqli_query($conn, "DELETE FROM Crew WHERE Crew.crew_ID = $crew");
		
		if($result == TRUE) {
			echo "Congratulations. They probably had kids to feed.";
			
			record($conn,"Deleted Crew","Administrator removed crew $crew");
		}
		else{
			echo "Failed to delete crew. Either their bond was no match for you, or you chose an invalid crew.";
		}
		
	}
		
?>