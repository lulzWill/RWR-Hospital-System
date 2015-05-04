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

	$to = $_POST["doctorEmail"];
	$subject = "Monthly Salary Payment";
	$content= "You have been paid for: " . $_POST["lastPaid"] . " to " . $_POST["today"] . "\n\nAmount Paid:\n$" . $_POST["payment"];
	$headers = "From:Appointments@rwrso.ls\r\n";

	if(mail($to,$subject,$content,$headers))
	{
		header("location: salaries.php");
	}
	else
	{
		header("location: salaries.php");
	}
?>