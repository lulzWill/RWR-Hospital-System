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
	$subject = "Appointment Successfully Paid";
	$content= "Your appointment made for: " . $_POST["aptDate"] . " at " . $_POST["aptTime"] . " has been successfully paid for!";

	if(mail($to,$subject,$content,$headers))
	{
		header("location: viewbilling.php");
	}
	else
	{
		header("location: viewbilling.php");
	}
?>