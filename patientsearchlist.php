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
  </head>

<?php
    require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	header('Cache-Control: no cache'); //no cache
	session_cache_limiter('private_no_expire'); // works
	//session_cache_limiter('public'); // works too
	
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
              <input type="hidden" class="form-control" name="patientemail" id="patientemail" value="
EOL;
echo $patient[0]->get("email");
echo <<<EOL
"> 
               <output type="submit">
            </form>
			<script type="text/javascript">document.getElementById("patientsearch").submit();</script>
EOL;
		}
		else
		{
			//profile pic, name, sex, age, email, address
			echo <<<EOL
			<body>
			<body>
			<div class="container">
			  <div class="row">
			  <div class="col-sm-2">
			    <h6 style="text-align: center">Profile Picture</h6>
			  </div>
			  <div class="col-sm-2">
			    <h6>Name</h6>
			  </div>
			  <div class="col-sm-1">
			    <h6>Sex</h6>
			  </div>
			  <div class="col-sm-1">
			    <h6>DOB</h6>
			  </div>
			  <div class="col-sm-3">
			    <h6>Email</h6>
			  </div>
			  <div class="col-sm-3">
			    <h6>Patient's Profile</h6>
			  </div>
			  </div>
			</div>
EOL;
		    for ($i = 0; $i < count($patient); $i++) {
               // This does not require a network access.
			   $profilePhoto = $patient[$i]->get("prof_pic");
			   echo '<div class="container"><div class="row"><div class="col-sm-2">';
			   echo '<img class="center-block" src="' . $profilePhoto->getURL() . '"></div>';
               echo '<div class="col-sm-2 "><h2>' . $patient[$i]->get("first_name") . ' ' . $patient[$i]->get("last_name") . '</h2>';
			   echo '</div><div class="col-sm-1 "><h2>' . $patient[$i]->get("sex") . '</h2>';
			   echo '</div><div class="col-sm-1 "><h2>' . $patient[$i]->get("date_of_birth") . '</h2>';
			   echo '</div><div class="col-sm-3 "><h2>' . $patient[$i]->get("email") . '</h2>';
			   echo '</div><div class="col-sm-3 ">';
echo <<<EOL
			<form method="POST" action="patientsearch.php" id="patientsearch">
              <input type="hidden" class="form-control" name="patientemail" id="patientemail" value="
EOL;
echo $patient[$i]->get("email");
echo <<<EOL
"> 
               <button type="submit" class="btn btn-default">View Patient's Profile</button>
            </form>
EOL;
			   echo '</div></div></div>';
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
  </body>
</body>
</html>
	
EOL;
?>