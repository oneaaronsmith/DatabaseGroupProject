<?php
	//This php introduces a function that will log all changes to employee information in a Changelog table.
	
	function record($conn,$action,$explain) {
	
	//Record time and ip address of employee making change
	date_default_timezone_set('America/Chicago');
	$date = date('d M Y');
	$time = date('h:i:s A');
	$ip = $_SERVER['REMOTE_ADDR'];
	
	//Set variables to track the employee being changed.
	$id = $_COOKIE['employeeId'];
	$first_name = $_COOKIE['firstName'];
	
	
	
	if($logstmt = mysqli_prepare($conn, "INSERT INTO Changelog (employee_ID,first_name,ip_address,action_type,explanation,date_occurred,time_occurred) VALUES (?,?,?,?,?,?,?)")) {
			
		mysqli_stmt_bind_param($logstmt,'issssss', $id, $first_name, $ip, $action, $explain, $date, $time);
		
		mysqli_stmt_execute($logstmt);
		
		mysqli_stmt_close($logstmt);
	}
	else{
		echo "Log failed";
	}
	
	}
?>
