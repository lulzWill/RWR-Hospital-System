<?php 
	require 'vendor/autoload.php';
	include_once("navbar.php");
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	ParseClient::setStorage( new ParseSessionStorage() );

	$to = $currentUser->get("email");
	$subject = "Appointment Rescheduled";
	$content= 'Your appointment made for: ' . $_POST["oldDate"] . ' at ' . $_POST["oldTime"] . ' has been reschedule for ' . $_POST["newDate"] . ' at ' . $_POST["newTime"];
	$headers = "From:Appointments@rwrso.ls\r\n";

	if(mail($to,$subject,$content,$headers))
	{
		$subject = "Appointment Rescheduled";
		$content= 'Your appointment for: ' . $_POST["oldDate"] . ' at ' . $_POST["oldTime"] . ' has been reschedule for ' . $_POST["newDate"] . ' at ' . $_POST["newTime"];
		$headers = "From:Appointments@rwrso.ls\r\n";
		mail($_POST["nurseEmail"],$subject,$content,$headers);
		mail($_POST["physicianEmail"],$subject,$content,$headers);
		header("location: viewappointments.php");
	}
	else
	{
		echo "an error has occurred";
	}
?>