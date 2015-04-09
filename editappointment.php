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
	/*
	if($currentUser->get("position") == "physician")
	{
		$query=new ParseQuery("appointments");
		$query->equalTo("objectId", $_POST["objectid"]);
		$appointment=$query->first();
		$appointment->set("available", "true");
		$appointment->delete("patientEmail");
		$appointment->delete("nurseEmail");
		$appointment->delete("specialty");
		try {
			$appointment->save();
		}
		catch (ParseException $ex) {  
			// Execute any logic that should take place if the save fails.
			// error is a ParseException object with an error code and message.
			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
		}
		header('Location: viewprofile.php');
	}
	*/
	
	if($currentUser->get("position") == "patient")
	{

		/*
		echo "old appt id: " . $_POST["currentObjectId2"];
		echo "old appt date: " . $_POST["currentDate2"];
		echo "old appt time: " . $_POST["currentTime2"];
		echo "doc: " . $_POST["currentDoctor2"];
		echo "doc email: " . $_POST["currentDoctorEmail2"];
		echo "nurse: " . $_POST["currentNurse2"];
		echo "nurse email: " . $_POST["currentNurseEmail2"];
		echo "new appt date: " . $_POST["selectDate"];
		echo "new appt time: " . $_POST["selectTime"];
		*/

		$myID = $_POST["currentObjectId2"];
		$query=new ParseQuery("appointments");
		$query->equalTo("objectId", $myID);
		$appointment=$query->first();
		var_dump($appointment);
		/*
		$appointment->set("available", "true");
		$appointment->delete("patientEmail");
		$appointment->delete("nurseEmail");
		$appointment->delete("specialty");
		try {
			$appointment->save();
		}
		catch (ParseException $ex) {  
			// Execute any logic that should take place if the save fails.
			// error is a ParseException object with an error code and message.
			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
		}
		header('Location: viewprofile.php');
		*/
	}

?>