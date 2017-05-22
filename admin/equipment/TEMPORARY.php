<?php
$pageTitle = "Admin - Edit Flights Page";
include("/var/www/html/group/CS3380GRP5/www/core/header.php");
include("/var/www/html/group/CS3380GRP5/www/core/navbar.html");
include("../core/secure/databaseConfig.php");
?>
	<link href="../style/adminStyles.css" rel="stylesheet">
	<hr>
	<div id='admin-edit-page'>
		<div style='background-color: white;'>
			<form action='TEMPORARY.php' method='post'>
				<input type='text' name='pass' value=''>
				<input type='submit' name='yep' value='go'>
			</form>
		</div>
	<hr>
	<?php
		if(isset($_POST['yep'])) {
		
			$password = $_POST['pass'];
			
			echo "Original Password: " . $password . "<br>";
			
			$password = hash('SHA256',$password);
			$password = hash('SHA512',$password);
			
			echo "Encrypted: " . $password;
		}
	?>
</div>