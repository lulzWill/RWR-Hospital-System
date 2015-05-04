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

	$to = $_POST["patientEmail"];
	$subject = "Appointment Available For Payment";
	$content= "Your appointment made for: " . $_POST["aptDate"] . " at " . $_POST["aptTime"] . " has been completed and is ready to be paid for! \n\nAppointment Notes:\n" . $_POST["aptNotes"] . "\n\n\nAppointment Price:\n$" . $_POST["aptPrice"];
	$headers = "From:Appointments@rwrso.ls\r\n";

	if(mail($to,$subject,$content,$headers))
	{
		header("location: adminBillingApproval.php");
	}
	else
	{
		header("location: adminBillingApproval.php");
	}
?>