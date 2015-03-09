<?php 
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseObject;
	use Parse\ParseException;
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	

	$user = new ParseUser();
	//$user->set("firstname", $_POST["firstname"]);
	//$user->set("lastname", $_POST["lastname"]);
	$user->set("password", $_POST["password"]);
	$user->set("email", $_POST["username"]);
	$user->set("username", $_POST["username"]);


	try {
	  $user->signUp();
	  // Hooray! Let them use the app now.
	  header("Location: signupsuccess.html");
		  exit;
	} catch (ParseException $ex) {
	  // Show the error message somewhere and let the user try again.
	  echo "Error: " . $ex->getCode() . " " . $ex->getMessage();
	  header("Location: test.html");
		  exit;
	}

	
?>