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
	  if($_POST["role"] == "patient")
	  {
		  $patient = new ParseObject("Patient");
		  $patient->set("email", $_POST["email"]);
	  	  $patient->set("first_name", $_POST["firstname"]);
	  	  $patient->set("last_name", $_POST["lastname"]);
		  $patient->set("date_of_birth", $_POST["date"]);
		  
		  try {
		    $patient->save();
		  } catch (ParseException $ex) {  
			  //send to errorpage here if something goes wrong.
		  }
	  }
	  	header("Location: signupsuccess.php");
		exit;
	} catch (ParseException $ex) {
	  // Show the error message somewhere and let the user try again.

	  $error_message = "Error: " . $ex->getCode() . " " . $ex->getMessage();
	  header("Location: signup.php?error_message=$error_message");
	  exit;
	}
?>