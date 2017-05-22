<?php
	function handleFlightAdd() {
		if(isset($_POST['confirm-addition'])) {
			$from = $_POST['departure_city'];
			$to = $_POST['arrival_city'];
			$time = $_POST['flight_time'];
			$arrival = $_POST['arrival_time'];
			$crew = $_POST['crew_ID'];
			$aircraft = $_POST['aircraft'];
			$price = $_POST['price'];
			
			//Set values for the dates the flight may be available:
			if(isset($_POST['Monday']))
				$monday = 1;
			else
				$monday = 0;
			if(isset($_POST['Tuesday']))
				$tuesday = 1;
			else
				$tuesday = 0;
			if(isset($_POST['Wednesday']))
				$wednesday = 1;
			else
				$wednesday = 0;
			if(isset($_POST['Thursday']))
				$thursday = 1;
			else
				$thursday = 0;
			if(isset($_POST['Friday']))
				$friday = 1;
			else
				$friday = 0;
			if(isset($_POST['Saturday']))
				$saturday = 1;
			else
				$saturday = 0;
			if(isset($_POST['Sunday']))
				$sunday = 1;
			else
				$sunday = 0;
			
			//Check for error constraints:
			
			//Constraint 1. The cities need to be different.
			if($from == $to) {
				echo "Error: Cannot depart and arrive in the same city.";
				return;
			}
						
			//Constraint 2. There needs to be a proper amount of attendants and pilots.
			$attendNeeded = employeeRequire($aircraft,"attendants_required");
			$pilotNeeded = employeeRequire($aircraft,"pilots_required");
			$attends = employeeNum($crew,"ATTENDANT");
			$pilots = employeeNum($crew,"PILOT");
			
			if($attendNeeded != $attends || $pilotNeeded != $pilots) {
				echo "Error: The employee crew does not meet the service requirements of this aircraft";
				return;
			}
			
			
			//include("../../core/secure/databaseConfig.php");
				$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
				
				if(mysqli_connect_error())
						echo "Connection to database failed: " . mysqli_connect_error();
					
				mysqli_query($conn, "USE" .  "CS3380GRP5");
				
				if($stmt = mysqli_prepare($conn, "INSERT INTO Flights (aircraft,departure_city,arrival_city,flight_time,arrival_time,crew_ID,price,monday,tuesday,wednesday,thursday,friday,saturday,sunday) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
					mysqli_stmt_bind_param($stmt,'ssssisiiiiiiii',$aircraft,$from, $to, $time, $arrival, $crew, $price,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);
					
					echo "<br>Addition successful";
				}
				else{
					echo "<br>Addition failed.";
				}
						
		}
	}
	
	//This file is for finding the number of a certain employee type in a crew.
	function employeeNum($crew,$type) {
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		//Announce error if there was an error
		if(mysqli_connect_error())
				echo "Connection to database failed: " . mysqli_connect_error();
		
		$role = $type;
		//For their reference.
		$result = mysqli_query($conn,"SELECT * FROM Crew WHERE crew_ID=". $crew ." AND role='".$type."'");
		
		$num = mysqli_num_rows($result);
		
		mysqli_close($conn);
		
		return $num;	
	}
	
	function employeeRequire($aircraft,$type) {
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		//Announce error if there was an error
		if(mysqli_connect_error())
				echo "Connection to database failed: " . mysqli_connect_error();
		
		//For their reference.
		$result = mysqli_query($conn,"SELECT ". $type ." FROM Equipment_type INNER JOIN Equipment ON Equipment_type.equipment = Equipment.equipment WHERE Equipment.serial_num = '". $aircraft ."'");
		$row = mysqli_fetch_assoc($result);
	
		$reqNum = $row[$type];
		
		mysqli_close($conn);
		
		return $reqNum;	
	}
	
	function setStatus($day) {
		if(isset($day)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
?>