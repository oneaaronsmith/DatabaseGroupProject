<!--This file is for use with admin/index.php It displays choices for what the admin can do.-->

<!--Link admin style sheet -->
<link href="/group/CS3380GRP5/www/style/adminStyles.css" rel="stylesheet">

<!--Wrapper div for home page-->
<div class='credential-check' style='visibility:hidden;'>
<div id='admin-home-page' class='col-xs-12 col-md-12 col-lg-12'>

	<!--Header for page message -->
	<div class='page-header'>
		<h1 id='header'>Welcome back <?php echo $_SESSION['role'];?><small><br>Please make a selection</small></h1>
	</div>
	
	<!--First choice is to monitor flights-->
	<div class='monitor-container'>
		<div class='form-container'>
			<form name='admin-monitor' id='admin-monitor' action=''>
				<input class='btn btn-primary btn-sm' id='admin-monitor-button' type='submit' value='Monitor flights'>
			</form>
		</div>
	</div>
	<hr>
	<!--Second choice is to check the change log-->
	<div class='change-container'>
		<div class='form-container'>
			<form name='admin-changelog' id='admin-changelog' action='adminChangelog.php'>
				<input class='btn btn-primary btn-sm' id='admin-changelog-button' type='submit' value='Check change log'>
			</form>
		</div>
	</div>
	<hr>
	<!--Third choice is to edit employee record-->
	<div class='admin-employee-container'>
		<div class='form-container'>
			<form name='admin-employee' id='admin-employee' action='employee/employeeEdit.php'>
				<input class='btn btn-primary btn-sm' id='mployee-button' type='submit' value='Edit employee records'>
			</form>
				<span id='errorMessage'></span>
		</div>
	</div>
	<hr>
	<!--Fourth choice is to edit flight records-->
	<div class='admin-flight-container'>
		<div class='form-container'>
			<form name='admin-flight' id='admin-flight' action='flightEdit.php'>
				<input class='btn btn-primary btn-sm' id='flight-button' type='submit' value='Edit flight records'>
			</form>
		</div>
	</div>
	<hr>
	<!--Final choice is to edit equipment records-->
	<div class='admin-equip-container'>
		<div class='form-container'>
			<form name='admin-equip' id='admin-equip' action='equipmentEdit.php'>
				<input class='btn btn-primary btn-sm' id='equip-button' type='submit' value='Edit equipment records'>
			</form>
		</div>
	</div>
	<hr>
</div>
</div>
	<!--<div id='admin-home-page'>
		<div class='page-header'>
			<h1 id='header'><br>This page is for administrators only<small><br>Please login to continue</small></h1>
		</div><div class='form-container'>
			<form name='login-button' id='login-button' action='' method='post'>
				<input class='btn btn-primary btn-sm' name='login' type='submit' value='login'>
			</form>
		</div>
	</div>-->
		
