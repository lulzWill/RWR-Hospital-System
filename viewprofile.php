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
	<link href="profile.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


<?php
	include_once("navbar.php"); 
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
	
	
	if($currentUser->get("position") == "patient")
	{
		echo <<<EOL
		    </head>
		    <body>
		  	<body>
			  <a href="editmyprofile.php">
				<h3>Edit Profile Information</h3>
		  		<h1>
			  </a>
EOL;
				echo $currentUser->get("firstname") . "'s Profile";
				echo <<<EOL
		  		</h1>
EOL;
		$query=new ParseQuery("Patient");
		$query->equalTo("email", $currentUser->get("email"));
		$patient=$query->first();
		
		if(!empty($patient->get("prof_pic")))
		{
			$profilePhoto = $patient->get("prof_pic");
			echo '<img src="' . $profilePhoto->getURL() . '">';
		}
		else if($currentUser->get("sex") == "female")
	    {
			// save file to Parse
			$file = ParseFile::createFromFile("bgs/FemaleStockPhoto.jpg", "myprofilepic.jpg");
			echo $file->getURL();
			$patient->set("prof_pic", $file);
			$patient->save();
			echo '<img src="bgs/FemaleStockPhoto.jpg"/>';
		} 
		else
		{
			// save file to Parse
			$file = ParseFile::createFromFile("bgs/FemaleStockPhoto.jpg", "myprofilepic.jpg");
			$file->save();
			$patient->set("prof_pic", $file);
			$patient->save();
			echo '<img src="bgs/MaleStockPhoto.png"/>';
		}
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
		
		echo '<a href="medicalrecords.php"><h5>Link to Medical Information</h5></a>';
		
	}
	echo <<<EOL
		  		</h2>
		  	</body>

		      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		      <!-- Include all compiled plugins (below), or include individual files as needed -->
		      <script src="js/bootstrap.min.js"></script>
		    </body>
		  </html>
EOL;
?>