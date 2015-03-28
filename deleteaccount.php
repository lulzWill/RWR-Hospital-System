<?php 
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;

	session_start();
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');

	ParseClient::setStorage( new ParseSessionStorage() );
    
	$currentUser = ParseUser::getCurrentUser();
	
	if($currentUser->get("position") == "patient")
	{
		$query=new ParseQuery("Patient");
		$query->equalTo("email", $currentUser->get("email"));
		$patient=$query->first();
		$patient->destroy();
	}
	else if($currentUser->get("position") == "physician")
	{
		$query=new ParseQuery("Physician");
		$query->equalTo("email", $currentUser->get("email"));
		$physician=$query->first();
		$physician->destroy();
	}
	else if($currentUser->get("position") == "nurse")
	{
		$query=new ParseQuery("Nurse");
		$query->equalTo("email", $currentUser->get("email"));
		$nurse=$query->first();
		$nurse->destroy();
	}
	
	$currentUser->destroy();
	
	ParseUser::logOut();
	session_unset();
	session_destroy();
	header("Location: index.php");
	exit;
?>