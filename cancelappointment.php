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
	if($currentUser->get("position") == "physician" || $currentUser->get("position") == "admin")
	{
		$query=new ParseQuery("appointments");
		$query->equalTo("objectId", $_POST["objectid"]);
		$appointment=$query->first();
		$appointment->set("available", "true");

		$to = $appointment->get("patientEmail");
		$tonurse = $appointment->get("nurseEmail");
		$toPhys = $appointment->get("physicianEmail");

		$subject = "Appointment Canceled";
		$content= 'Your appointment made for: ' . $appointment->get("Date") . ' at ' . $appointment->get("Time") . ' has been canceled.';
		$headers = "From:Appointments@rwrso.ls\r\n";

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

		if(mail($to,$subject,$content,$headers))
		{
			mail($tonurse,$subject,$content,$headers);
			mail($toPhys,$subject,$content,$headers);
			header("location: " . $_SERVER['HTTP_REFERER']);
		}
		else
		{
			header("location: " . $_SERVER['HTTP_REFERER']);
		}
	}
	if($currentUser->get("position") == "patient")
	{
		//echo $_POST["objectid"];
		
		
		$query=new ParseQuery("appointments");
		$query->equalTo("objectId", $_POST["objectid"]);
		$appointment=$query->first();

		$to = $appointment->get("patientEmail");
		$tonurse = $appointment->get("nurseEmail");
		$toPhys = $appointment->get("physicianEmail");

		$subject = "Appointment Canceled";
		$content= 'Your appointment made for: ' . $appointment->get("Date") . ' at ' . $appointment->get("Time") . ' has been canceled.';
		$headers = "From:Appointments@rwrso.ls\r\n";

		$appointment->set("available", "true");
		$appointment->delete("patientEmail");
		$appointment->delete("nurseEmail");
		$appointment->delete("specialty");
		$appointment->delete("paymentStatus");
		$appointment->delete("price");
		try {
			$appointment->save();
		}
		catch (ParseException $ex) {  
			// Execute any logic that should take place if the save fails.
			// error is a ParseException object with an error code and message.
			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
		}
		
		if(mail($to,$subject,$content,$headers))
		{
			mail($tonurse,$subject,$content,$headers);
			mail($toPhys,$subject,$content,$headers);
			header("location: " . $_SERVER['HTTP_REFERER']);
		}
		else
		{
			header("location: " . $_SERVER['HTTP_REFERER']);
		}
	}
?>