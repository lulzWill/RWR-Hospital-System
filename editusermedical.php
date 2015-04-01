<?php 
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	use Parse\ParseFile;
	
	session_start();
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	ParseClient::setStorage( new ParseSessionStorage() );
	$currentUser = ParseUser::getCurrentUser();
	$currentUser->save();
	
	if(!$currentUser)
	{
		header("Location: index.php");
		exit;
	}
	
	if($currentUser->get("position") == "patient")
	{
		$query=new ParseQuery("Patient");
		$query->equalTo("email", $currentUser->get("email"));
		$patient=$query->first();
		$patient->set("medications", $_POST["medications"]);
		$patient->set("allergies", $_POST["allergies"]);
		$patient->set("pre_conditions", $_POST["pre_conditions"]);
		$patient->set("insurance", $_POST["insurance"]);
		try {
			$patient->save();
		}
		catch (ParseException $ex) {  
			// Execute any logic that should take place if the save fails.
			// error is a ParseException object with an error code and message.
			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
		}
		header('Location: viewprofile.php');
	}
?>