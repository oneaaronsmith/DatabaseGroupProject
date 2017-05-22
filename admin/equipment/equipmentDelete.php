<?php
$pageTitle = "Admin - Edit Equipment Page";
include("../../core/header.php");
include("../../core/navbar.html");
?>

<link href="../../style/adminStyles.css" rel="stylesheet">

<div id="admin-edit-page">
		
			<div class="page-header">
			<h1 id="header">Warning: All deletions are final.<small> <br>Deleted records may not be recovered.</small></h1>
			</div>

<?php							
	$equipment = $_POST['equipment'];
	$serial_num = $_POST['serial_num'];
	
	echo "You are about to delete the following record: ";
	
	echo "<div class='form-container'>
			<form action='equipmentDelete.php' method='post'>
				<table>
					<th>equipment</th><th>serial number</th>
					<tr>
						<td><input type='text' name='equipment' value='$equipment' readonly></td>
						<td><input type='text' name='serial_num' value='$serial_num' readonly></td>
					</tr>
				</table>
				<br> <input type='submit' name='confirm-delete' class='btn btn-primary btn-sm cancel' value='Confirm Deletion'>
			  </form>
			</div>";
		  
	echo "<br>";
	
	echo "If you do not wish to continue you may return to the equipment edit page.";
	
	echo "<div class='form-container'>
			<form action='../equipmentEdit.php' method='post'>
				<input type='submit' class='btn btn-primary btn-sm cancel' value='Cancel'>
			 </form>
		  </div>";
		  

	if(isset($_POST['confirm-delete'])) {
	
		$equipment = $_POST['equipment'];
		$serial_num = $_POST['serial_num'];
		
		include("../../core/secure/databaseConfig.php");
					$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
					
					if(mysqli_connect_error())
							echo "Connection to database failed: " . mysqli_connect_error();
						
					mysqli_query($conn, "USE" .  "CS3380GRP5");
						
					$result = mysqli_query($conn, "DELETE FROM Equipment WHERE serial_num = '$serial_num'");
					
					if($result == TRUE) {
						include('../../changelog/recordChange.php');
						record($conn,"Delete Equipment","Administrator deleted equipment $equipment with serial number $serial_num");
						echo "<br>Deletion successful. Returning to Equipment edit page in ";
						echo "<span id='timer'>5</span>";
					}
					else{
						echo "<br>Deletion failed. Returning to Equipment edit page in ";
						echo "<span id='timer'>5</span>";
					}
					
					include('countdownEquipment.html');
	}
?>


</div>

<?php
include("../../core/footer.html");
?>

