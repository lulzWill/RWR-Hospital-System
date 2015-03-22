<?php
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	
	session_start();
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	$currentUser = ParseUser::getCurrentUser();
	if($currentUser)
	{
		header("Location: homepage.php");
		exit;
	}
	else
	{
		$query = ParseUser::query();
		$query->equalTo("email", $_SESSION["emailattempt"]);
		$results = $query->find();
	
		if(empty($results[0]))
		{
	  	  header("Location: test.php");
	  	  exit;
		}
		try {
		  $user = ParseUser::logIn($results[0]->get("username"), $_SESSION["temppassword"]);
		  // Do stuff after successful login.
  		  $user->set("email", $_SESSION["emailattempt"]);	
  		  $user->save();
		} catch (ParseException $error) {
		  // The login failed. Check error to see why.
		}
		include_once("logoutcurusr.php");
	}
?>