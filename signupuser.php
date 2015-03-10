<?php 
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseObject;
	use Parse\ParseException;
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	

	$user = new ParseUser();
	$user->set("firstname", $_POST["firstname"]);
	$user->set("lastname", $_POST["lastname"]);
	$user->set("position", $_POST["role"]);
	$user->set("password", $_POST["password"]);
	$user->set("email", $_POST["username"]);
	$user->set("username", $_POST["username"]);
	$user->set("dateOfBirth", $_POST["date"]);


	try {
	  $user->signUp();
	  // Hooray! Let them use the app now.
	  if ($_POST["role"] == "physician") {
	  	header("Location: physician_home.php");
		exit;
	  }
	  else if ($_POST["role"] == "nurse") {
	  	header("Location: nurse_home.php");
		exit;
	  }
	  else if ($_POST["role"] == "admin") {
	  	header("Location: admin_home.php");
		exit;
	  }
	  else if ($_POST["role"] == "patient") {
		header("Location: patient_home.php");
		exit;
	  }
	  else {
	  	header("Location: signupsuccess.php");
	  	exit;
	  }
	} catch (ParseException $ex) {
	  // Show the error message somewhere and let the user try again.

	  $error_message = "Error: " . $ex->getCode() . " " . $ex->getMessage();
	  header("Location: signup.php?error_message=$error_message");
	  exit;
	}

	
?>