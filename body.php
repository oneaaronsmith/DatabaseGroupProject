<!-- Image Carousel -->


<div id="carousel-container">
  <img class="slider-image" id="preloaded-image" src="/group/CS3380GRP5/www/img/mountains.jpg"/>
</div>
<div class="caption-bg" id="caption-container">
  <p class="caption-text" id="preloaded-caption">Your Gateway to the West</p>
</div>

<div id="book-travel-container">
  <div class="page-header">
  	<h1 id="header">Get Away <small>Book Travel Now</small></h1>
  </div>
  <div class="book-travel">
    <div class="form-container">
	       <form method="post" name="book-travel" id="book-travel-form" action="" autocomplete="off">

<!--  Input fields for search -->

          <h4>Search for flights:</h4>

              <label for="departure_city">Departure City: </label>
	             <input type="text" name="departure_city" placeholder="Columbia">

              <label for="arrival_city">Arrival City: </label>
              <input type="text" name="arrival_city" placeholder="New York">

              <label for="flight_date">Date: </label>
              <input type="text" name="flight_date" placeholder="YYYY-MM-DD" style="width:170px">

              <label for="flight_time">Time :</label>
              <input type="text" placeholder="18:00" name="flight_time">

              <label for="price">Max Price: </label>
              <input type="text" name="price" placeholder="800" style="width:100px">

              <br>

              <label for="sortField">Sort By: </label>
              <select name="sortField">
                <option value="departure_city" selected>Departure City</option>
                <option value="arrival_city">Arrival City</option>
                <option value="flight_date">Date</option>
                <option value="flight_time">Time</option><br>
                <option value="price">Price</option>
              </select>

            <input class="btn btn-primary btn-sm" id="submit-button" type="submit" name="search">
	        </form>

          <div class="searchTable">
  <?php

          include("core/Database.php");

          if(isset($_POST['search'])){

// Template SQL code
            $stmt = "SELECT * FROM Flights WHERE" .
                      " departure_city LIKE '" . $_POST['departure_city'] . "%'" .
                      " AND arrival_city LIKE '" . $_POST['arrival_city'] . "%'" .
                      " AND flight_date LIKE '" . $_POST['flight_date'] . "%'" .
                      " AND flight_time LIKE '" . $_POST['flight_time'] . "%'";

// Check if price field is empty
            if(!empty($_POST['price'])){
              $stmt .= " AND price < " . $_POST['price'];
            }

// Concatenate ORDER BY statement            
            if(isset($_POST['sortField'])){
              $stmt .= " ORDER BY ". $_POST['sortField'] . " ASC";
            }

// Establish connection
            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);

// Prepare query
            $query = mysqli_prepare($conn, $stmt) or die ("Query error: " . mysqli_error($conn));

// Done with SQL, now fetches a result from DB and prints it

            mysqli_stmt_execute($query);
            $result = mysqli_stmt_get_result($query);
            mysqli_stmt_fetch($query);
            printTable($result);
            mysqli_close($conn);
          }

          function printTable($result){

           echo "<br>";
           echo "<table class ='table table-bordered table-hover table-responsivez'>";
           echo "<thead>";

// Print headers from "Flights" relevant to customer
           echo "<th>". "Flight Number" . "</th>\n";
           echo "<th>". "Departure City" . "</th>\n";
           echo "<th>". "Arrival City" . "</th>\n";
           echo "<th>". "Flight Date" . "</th>\n";
           echo "<th>". "Flight Time" . "</th>\n";
           echo "<th>". "Arrival Time" . "</th>\n";
           echo "<th>". "Price" . "</th>\n";
           echo "<th>Book Flight!</th>";
           echo "</thead>";

// Print only values relevant to the customer
           while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
             echo "<tr>";
             echo "<td>" . $row['flight_number'] . "</td>";
             echo "<td>" . $row['departure_city'] . "</td>";
             echo "<td>" . $row['arrival_city'] . "</td>";
             echo "<td>" . $row['flight_date'] . "</td>";
             echo "<td>" . $row['flight_time'] . "</td>";
             echo "<td>" . $row['arrival_time'] . "</td>";
             echo "<td>" . $row['price'] . "</td>";

// Handle "Book" button and hidden variables
            echo "<td>";
            echo "<form action='http://cs3380.rnet.missouri.edu/group/CS3380GRP5/www/reservations/' method='POST'>";
            echo "<input class='btn btn-primary btn-sm' id='submit-button' type='submit' name='bookFlight' value='Reserve'>";
    			  echo "<input type = 'hidden' name='flight_number' value='$row[flight_number]'> ";
            echo "<input type = 'hidden' name='departure_city' value = '$row[departure_city]'>";
            echo "<input type = 'hidden' name='arrival_city' value = '$row[arrival_city]'>";
            echo "<input type = 'hidden' name='flight_date' value = '$row[flight_date]'>";
            echo "<input type = 'hidden' name='flight_time' value ='$row[flight_time]'>";
            echo "<input type = 'hidden' name='arrival_time' value = '$row[arrival_time]'>";
            echo "<input type = 'hidden' name='crew_ID' value = '$row[crew_ID]'>";
            echo "<input type = 'hidden' name='aircraft' value = '$row[aircraft]'>";
            echo "<input type = 'hidden' name='price' value = '$row[price]'>";

            echo "</form>";
            echo "</td>";
            echo "</tr>";
           }
           echo "</table>";
         }



  ?>
          </div>


	    <span id="errorMessage"></span>
	  </div>
  </div>
</div>
