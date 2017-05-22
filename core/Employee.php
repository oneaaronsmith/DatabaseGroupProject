<?php

include_once("Database.php");

class Employee {
	private $employeeId;
	private $username;
	private $password;
	private $firstName;
	private $lastName;
	private $email;
	private $role;

	public static function getProfile($employeeId) {
		// Establish DB connection.
		Database::establishConnection();

		// Get profile.
		$stmt = Database::$connection->prepare("SELECT * FROM Employee WHERE employee_ID=?");
		$stmt->bind_param("s", $employeeId);

		// Execute and get result.
		$stmt->execute();

		// Get result associative array.
		$result = mysqli_fetch_assoc($stmt->get_result());

		// Close stmt.
		$stmt->close();

		// Close connection.
		Database::$connection->close();

		// Successful login.
		return $result;
	}

	public function register($username, $password, $firstName, $lastName, $email, $role) {
		// Establish DB connection.
		Database::establishConnection();

		// Store user information.
		$this->username = $username;
		$this->password = hash("SHA256", $password);
		$this->password = hash("SHA512", $this->password);
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->role = $role;

		// Add to employee table.
		$stmt = Database::$connection->prepare("INSERT INTO Employee (first_name, last_name, email_address, username, role) VALUES(?,?,?,?,?)");
		$stmt->bind_param("sssss", $this->firstName, $this->lastName, $this->email, $this->username, $this->role);

		// Get employee ID.
		$this->employeeId = Database::$connection->query("SELECT LAST_INSERT_ID();");

		// Add to Authentication table.
		$stmt = Database::$connection->prepare("INSERT INTO Authentication VALUES(?,?,?)");
		$stmt->bind_param("sss", $this->employeeId, $this->password, $this->role);

		// Get registration result.
		if ($stmt->execute() == TRUE) {
			// Close stmt.
			$stmt->close();

			// Close connection.
			Database::$connection->close();

			// Successful registration.
			return TRUE;
		}
		else {
			// Registration not successful.
			return FALSE;
		}
	}


}
