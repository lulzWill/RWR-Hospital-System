<?php 
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	$query = ParseUser::query();
	$query->equalTo("username", $_POST["username"]);
	$results = $query->find();
	$userValidate = $results[0];
	$userValidate = $userValidate->get("emailVerified");
	
	if(!$userValidate)
	{
		header("Location: emailerr.html");
		exit;
	}
	try {
	  $user = ParseUser::logIn($_POST["username"], $_POST["password"]);
	  // Do stuff after successful login.
	  header("Location: loginsuccess.php");
	  exit;
	} catch (ParseException $error) {
	  // The login failed. Check error to see why.
	  header("Location: test.php");
	  exit;
	}
?>