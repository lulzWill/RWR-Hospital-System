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
	$currentUser->save();
	try {
		if($currentUser->get("position") == "patient")
		{
			$query=new ParseQuery("Patient");
			$query->equalTo("email", $currentUser->get("email"));
			$patient=$query->first();
			$patient->set("insurance", $_POST["insurance"]);
			$patient->set("allergies", $_POST["allergies"]);
			$patient->set("pre_conditions", $_POST["pre_conditions"]);
			$patient->set("emerg_name", $_POST["emerg_name"]);
			$patient->set("emerg_num", $_POST["emerg_num"]);
			$patient->set("address", $_POST["address"]);
			$patient->set("citystate", $_POST["citystate"]);
			$patient->set("cellphone", $_POST["cellphone"]);
			$patient->set("homephone", $_POST["homephone"]);
			$patient->set("emerg_rel", $_POST["emerg_rel"]);
			$patient->save();
		}
		header('Location: viewprofile.php');
		
	}
	catch (ParseException $ex) {  
			  //send to errorpage here if something goes wrong.
	}
?>