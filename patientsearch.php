<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>
  		Hospital Login Page
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="othersprofile.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<?php
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	include_once("navbar.php");
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	ParseClient::setStorage( new ParseSessionStorage() );
	
	$currentUser = ParseUser::getCurrentUser();
	
	if(!$currentUser)
	{
		header("Location: index.php");
		exit;
		
	}
	
	$name = strtolower($_POST["patientname"]);
	$query=new ParseQuery("Patient");
	$query->equalTo("name", $name);
	$patient=$query->first();
	if(!empty($patient))
	{
echo <<<EOL
		</head>
		    <body>
		  	<body>
		  		<h1>
EOL;
				echo "Patient " . $patient->get("first_name") . " " . $patient->get("last_name");
				echo <<<EOL
		  		</h1>
EOL;
		if(!empty($patient->get("prof_pic")))
		{
			$profilePhoto = $patient->get("prof_pic");
			echo '<div class="image"><img src="' . $profilePhoto->getURL() . '"></div>';
		}
		echo '<div class="container">';
		echo "<h4>Patient Contact Information</h4>";
		echo "<h2> Patient Name: " . $patient->get("first_name") . " " . $patient->get("last_name") . "</br>";
		if(!empty($patient->get("address")))
		{
			echo "Home Address: " . $patient->get("address") . ", " . $patient->get("citystate") . ", " . $patient->get("zipcode") . "</br>";
		}
		else
		{
			echo "Home Address: </br>";
		}
		echo "Home Phone: " . $patient->get("homephone") . " </br>";
		echo "Cell Phone: " . $patient->get("cellphone") . "</br>";
		echo "Email Address: " . $patient->get("email") . "</br>";
		echo "</h2>";
		
		echo "<h4>Emergency Contact Information</h4>";
		echo "<h2> Primary's Name: " . $patient->get("emerg_name") . "</br>";
		echo "Primary's Number: " . $patient->get("emerg_num") . "</br>";
		echo "Primary's Relationship: " . $patient->get("emerg_rel") . "</br>";
		echo "<h2> Secondary's Name: " . $patient->get("emerg_name2") . "</br>";
		echo "Secondary's Number: " . $patient->get("emerg_num2") . "</br>";
		echo "Secondary's Relationship: " . $patient->get("emerg_rel2") . "</br>";
		echo "</h2>";
		
		echo '</div>';
		echo '<div class="container2">';
		echo "<h4>Patient Personal Information</h4>";
		echo "<h2> Sex: " . $patient->get("sex") . "</br>";
		echo "Date of Birth: " . $patient->get("date_of_birth") . " </br>";
		echo "Insurance: " . $patient->get("insurance") . "</br>";
		echo "Allergies: " . $patient->get("allergies") . "</br>";
		echo "Pre-existing Conditions: " . $patient->get("pre_conditions") . "</br>";
		echo "Current Medications: " . $patient->get("medications");
		echo "</h2>";
		
		echo '</div>';
	}
	else
	{
		header('Location: viewprofile.php');
	}
	
	

?>