<?php

include_once("Database.php");
include("Employee.php");

Class Authentication {

	public static function login($employeeId, $password) {
		// Check if credentials are correct.
		if (Authentication::checkCredentials($employeeId, $password)) {
			// Get profile
			$profile = Employee::getProfile($employeeId);

			// Set cookies.
			setcookie('employeeId', $employeeId, 0, '/group/CS3380GRP5/');
			setcookie('role', $profile['role'], 0, '/group/CS3380GRP5/');
			setcookie('firstName', $profile['first_name'], 0, '/group/CS3380GRP5/');

			// Login successful.
			return $profile['role'];
		}
		else {
			// Login not successful.
			return FALSE;
		}
	}

	private static function checkCredentials($employeeId, $password) {
		// Establish DB connection.
		Database::establishConnection();

		// Prepare query and bind params.
		$stmt = Database::$connection->prepare("SELECT password FROM Authentication WHERE employee_ID=? AND password=?");
		$stmt->bind_param("ss", $employeeId, $password);

		// Execute query.
		$stmt->execute();

		// Get login result.
		if ($stmt->fetch() == TRUE) {
			// Close stmt.
			$stmt->close();

			// Close connection.
			Database::$connection->close();

			// Successful login.
			return TRUE;
		}
		else {
			// Login not successful.
			return FALSE;
		}
	}

	public static function logout() {
			// Clear the cookies.
			setcookie('employeeId', '', time()-3600, '/group/CS3380GRP5/');
			setcookie('role', '', time()-3600, '/group/CS3380GRP5/');
			setcookie('firstName', '', time()-3600, '/group/CS3380GRP5/');

			// Notify the user they have been logged out and redirect.
			echo "<script>alert(\"You have been logged out.\");</script>";
			echo "<script>window.location=\"/group/CS3380GRP5/www/login/\";</script>";
	}
}
