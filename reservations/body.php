<link href="style/main.css" type="text/css" rel="stylesheet">
<br><br><br>
<?php

  $flight_num = $_POST['flight_number'];
  $depart = $_POST['departure_city'];
  $arrive = $_POST['arrival_city'];
  $date = $_POST['flight_date'];
  $time = $_POST['flight_time'];
  $arrivalTime = $_POST['arrival_time'];
  $crewID = $_POST['crew_ID'];
  $aircraft = $_POST['aircraft'];
  $price = $_POST['price'];


?>
<div id="reservation-container">
    <h2>Reservations</h2>
  <form name="reservation" id="reservation-form" action="" method="POST" autocomplete="off">
    <span class="label">First Name*</span><br>
    <input type="text" name="fname" required><br>
    <span class="label">Last Name*</span><br>
    <input type="text" name="lname" required><br>
    <span class="label"># of Bags*</span><br>
    <input type="number" min="0" max="10" name="bags" required><br>
    <span class="label">Age*</span><br>
    <input type="number" name="age" min="0" required><br>
    <span class="label">Departure City</span><br>
    <input type="text" disabled="disabled" name="departure_city" value="<?php echo $depart; ?>"><br>
    <span class="label">Arrival City</span><br>
    <input type="text" disabled="disabled" name="arrival_city" value="<?php echo $arrive; ?>"><br>
    <span class="label">Date</span><br>
    <input type="text" name="flight_date" disabled="disabled" value="<?php echo $date; ?>"
    <span class="label">Price</span><br>
    <input type="text" disabled="disabled" name="price" value="<?php echo $price; ?>">

    <span id="errorMessage"></span>
    <input class="btn btn-primary btn-sm" id="submit-button" type="submit" name="reserve" value="Reserve!">
<?php
    include("../core/secure/databaseConfig.php");

    if(isset($_POST['reserve'])){
// Find airplane name based on airplane serial number
      $stmt = "SELECT equipment FROM Equipment WHERE serial_num = " . $aircraft;
      $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die ("Connection error");
      $result = mysqli_query($conn, $stmt);
      $plane_name = mysqli_fetch_field($result);

// Find number of seats on plane based on plane name
      $stmt = "SELECT seats FROM Equipment_type WHERE equipment = " . $_POST['plane_name'];
      $result = mysqli_query($conn, $stmt);
      $num_seats_available = mysqli_fetch_field($result);

// Find highest seat reservation based on flight number
      $stmt = "SELECT MAX(seat) FROM Reservation WHERE flight_number = " . $flight_num;
      $result = mysqli_query($conn, $stmt);
      $highest_seat_reserved = mysqli_fetch_field($result);
// Check for false (no reservation has been made for this flight number)
      if(!mysqli_query($conn, $stmt)){
        $seat = 1;
      }

// Check if all seats are filled
      if($highest_seat_reserved == $num_seats){
        echo '<script language="javascript">';
        echo 'alert("All seats for this flight have been reserved!")';
// Redirect to home page
        echo "window.location = 'http://cs3380.rnet.missouri.edu/group/CS3380GRP5/www/'";
        echo "</script>";

      }

// All conditions to not update DB have been checked



// Update Reservation table
      $stmt = "INSERT INTO Reservation (flight_number, price, seat, num_bags)
               VALUES (?, ?, ?, ?, ?)";
      $result = mysqli_query($conn, $stmt);
      $updatedPrice = ($price + $_POST['bags']) * 1.05;
      mysqli_stmt_bind_param($query, "iiii", $flight_num, $updatedPrice, $seat, $_POST['bags']);

// Retrieve reservation_ID from new record in Reservation table
      $stmt = "SELECT reservation_ID FROM Reservation WHERE flight_number = ? AND seat = ?";
      $query = mysqli_prepare($conn, $stmt);
      mysqli_stmt_bind_param($query, "iss", $flight_num, $seat);
      $reservation_ID = mysqli_stmt_execute($query);

// Update Customer table
      $stmt = "INSERT INTO Customer (first_name, last_name, age) VALUES (?, ?, ?)";
      $query = mysqli_prepare($conn, $stmt);
      mysqli_stmt_bind_param($query, "ssi", $_POST['fname'], $_POST['lname'], $_POST['age']);
      mysqli_stmt_execute($query);

      echo "<input type = 'hidden' name='flight_number' value='$flight_num'> ";
      echo "<input type = 'hidden' name='departure_city' value = '$depart'>";
      echo "<input type = 'hidden' name='arrival_city' value = '$arrive'>";
      echo "<input type = 'hidden' name='flight_date' value = '$date'>";
      echo "<input type = 'hidden' name='flight_time' value ='$time'>";
      echo "<input type = 'hidden' name='arrival_time' value = '$arrivalTime'>";
      echo "<input type = 'hidden' name='crew_ID' value = '$crewID'>";
      echo "<input type = 'hidden' name='aircraft' value = '$aircraft'>";
      echo "<input type = 'hidden' name='price' value = '$price'>";



      mysqli_close($conn);
    }




?>
  </form>
</div>
