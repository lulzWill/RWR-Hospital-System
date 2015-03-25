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
	$currentUser->set("sex", $_POST["sex"]);
	$currentUser->save();
	try {
		if($currentUser->get("position") == "patient")
		{
			$query=new ParseQuery("Patient");
			$query->equalTo("email", $currentUser->get("email"));
			$patient=$query->first();
			echo $patient->getObjectId() . $patient->get("email");
		}
	}
	catch (ParseException $ex) {  
			  //send to errorpage here if something goes wrong.
	}
?>