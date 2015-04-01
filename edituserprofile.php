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
		$patient->set("emerg_name", $_POST["emerg_name"]);
		$patient->set("emerg_num", $_POST["emerg_num"]);
		$patient->set("address", $_POST["address"]);
		$patient->set("citystate", $_POST["citystate"]);
		$patient->set("cellphone", $_POST["cellphone"]);
		$patient->set("homephone", $_POST["homephone"]);
		$patient->set("emerg_rel", $_POST["emerg_rel"]);
		$patient->set("zipcode", $_POST["zipcode"]);
		$patient->set("emerg_name2", $_POST["emerg_name2"]);
		$patient->set("emerg_num2", $_POST["emerg_num2"]);
		$patient->set("emerg_rel2", $_POST["emerg_rel2"]);
		$file = ParseFile::createFromFile($_POST["prof_pic"], "myprofilepic.jpg");
		$file->save();
		$patient->set("prof_pic", $file);
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
	else if($currentUser->get("position") == "physician")
	{
		$query=new ParseQuery("Physician");
		$query->equalTo("email", $currentUser->get("email"));
		$physician=$query->first();
		$physician->set("degree", $_POST["degree"]);
		$physician->set("school", $_POST["school"]);
		$physician->set("area_of_spec", $_POST["area_of_spec"]);
		$physician->set("experience", $_POST["experience"]);
		$physician->set("address", $_POST["address"]);
		$physician->set("citystate", $_POST["citystate"]);
		$physician->set("phone", $_POST["phone"]);
		$physician->set("zipcode", $_POST["zipcode"]);
		$file = ParseFile::createFromFile($_POST["prof_pic"], "myprofilepic.jpg");
		$file->save();
		$physician->set("prof_pic", $file);
		try {
			$physician->save();
		}
		catch (ParseException $ex) {  
			// Execute any logic that should take place if the save fails.
			// error is a ParseException object with an error code and message.
			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
		}
		header('Location: viewprofile.php');
	}
	else if($currentUser->get("position") == "nurse")
	{
		$query=new ParseQuery("Nurse");
		$query->equalTo("email", $currentUser->get("email"));
		$nurse=$query->first();
		$nurse->set("degree", $_POST["degree"]);
		$nurse->set("school", $_POST["school"]);
		$nurse->set("department", $_POST["department"]);
		$nurse->set("experience", $_POST["experience"]);
		$nurse->set("address", $_POST["address"]);
		$nurse->set("citystate", $_POST["citystate"]);
		$nurse->set("zipcode", $_POST["zipcode"]);
		$nurse->set("phone", $_POST["phone"]);
		$file = ParseFile::createFromFile($_POST["prof_pic"], "myprofilepic.jpg");
		$file->save();
		$nurse->set("prof_pic", $file);
		try {
			$nurse->save();
		}
		catch (ParseException $ex) {  
			// Execute any logic that should take place if the save fails.
			// error is a ParseException object with an error code and message.
			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
		}
		header('Location: viewprofile.php');
	}
?>