<?php 
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	try {
	  $user = ParseUser::logIn($_POST["username"], $_POST["password"]);
	  // Do stuff after successful login.
	  header("Location: loginsuccess.html");
	  exit;
	} catch (ParseException $error) {
	  // The login failed. Check error to see why.
	  header("Location: test.html");
	  exit;
	}
?>