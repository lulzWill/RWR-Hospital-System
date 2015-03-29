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
	<link href="patientlist.css" rel="stylesheet">
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
	$patient=$query->find();
	$query->descending("date_of_birth");
	if(!empty($patient))
	{
		if(count($patient) == 1)
		{
			echo <<<EOL
			<form method="POST" action="patientsearch.php" id="patientsearch">
              <input type="hidden" class="form-control" name="patientname" id="patientname" value="
EOL;
echo $patient[0]->get("name");
echo <<<EOL
"> 
               <output type="submit">
            </form>
			<script type="text/javascript">document.getElementById("patientsearch").submit();</script>
EOL;
		}
		else
		{
		    for ($i = 0; $i < count($patient); $i++) {
               // This does not require a network access.
               echo '<div class="container"><h2>' . $patient[$i]->get("first_name") . $patient[$i]->get("lastname") . '</h2></div>';
            }	
		}
	}
	else
	{
		header('Location: viewprofile.php');
	}
	
echo <<<EOL
	<script type="text/javascript">
       document.getElementById('jsform').submit();
    </script>
	
EOL;
?>