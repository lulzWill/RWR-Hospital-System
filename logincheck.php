<?php 
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseQuery;
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	$query = new ParseQuery("Users");
	$query->equalTo("email", $_POST["username"]);
	$query->equalTo("password", $_POST["password"]);
	$results = $query->find();
	
	
	if(count($results) === 1)
	{
		header("Location: loginsuccess.html");
		exit;
	}
	else
	{
		header("Location: test.html");
		exit;
	}
?>