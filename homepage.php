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
		header("Location: test.php");
		exit;
		
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>
  		Home
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="homepage.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
	function changeOpacityIn(ele)
	{
		var element = document.getElementById(ele.id);
		element.style.opacity = ".6";
	}
	
	function changeOpacityOut(ele)
	{
		var element = document.getElementById(ele.id);
		element.style.opacity = "1.0";
	}

	</script>
	<!-- Include Parse Stuff -->
    <script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>
  </head>
  
  <body>
	  <div class="header-image">
		  <div style="opacity: .6; position: absolute; bottom: 0; left: 28%; width: 70%; font-weight: bold; font-size: 44px; color: #000; margin-bottom: 170px;">
		  	<h1 style="margin-left: 23%; font-size: 55px;">RWR</h1><p>Hospital Management System</p>
	  	  </div>
	  </div>
	  <?php
	  if($currentUser->get("position") == "patient")
	  {
		  echo <<<EOL
	  <div style="position: relative; margin-left: 30%; width: 70%; height: 160px">
	  	<a href="makeappointment.php"><img src="icons/appointmenticon.png" alt="appointment temp" class="img-circle button-right" height="140px" width="140px" id="appt" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a>
	  	<a href="viewprofile.php"><img src="icons/viewprofileicon.png" alt="prof temp" class="img-circle button-right" height="140px" width="140px" id="prof" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a>
	  	<a href="viewappointments.php"><img src="icons/viewappointment.png" alt="temp" class="img-circle button-right" height="140px" width="140px" id="temp" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a> 
	  	<a href="viewbilling.php"><img src="icons/billinghistoryicon.png" alt="billing temp" class="img-circle button-right" height="140px" width="140px" id="billing" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a> 	
  	  </div>
EOL;
	  }
	  else if($currentUser->get("position") == "admin")
	  {
	  	  echo <<<EOL
	  <div style="position: relative; margin-left: 30%; width: 70%; height: 160px">
	  	<a href=adminEditAppointments.php><img src="icons/editappointmentsryan.png" alt="appointment temp" class="img-circle button-right" height="140px" width="140px" id="appt" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a>
	  	<a href="editusers.php"><img src="icons/editusersryan.png" alt="prof temp" class="img-circle button-right" height="140px" width="140px" id="prof" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a>
	  	<a href="adminEditSignupKeys.php"><img src="icons/editkeys.png" alt="temp" class="img-circle button-right" height="140px" width="140px" id="temp" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a>  
		<a href="salaries.php"><img src="icons/salariesryan.png" alt="temp3" class="img-circle button-right" height="140px" width="140px" id="temp3" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a>  
   	  	<a href="adminBillingApproval.php"><img src="icons/approvedenyrequest.png" alt="temp" class="img-circle button-right" height="140px" width="140px" id="temp2" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a>  		
  	  </div>
EOL;
	  }
	  else
	  {
		  echo <<<EOL
	  <div style="position: relative; margin-left: 39%; width: 61%; height: 160px">
	  	<a href="viewprofile.php"><img src="icons/viewprofileicon.png" alt="prof temp" class="img-circle button-right" height="140px" width="140px" id="prof" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a>
	  	<a href="viewappointments.php"><img src="icons/viewappointment.png" alt="temp" class="img-circle button-right" height="140px" width="140px" id="temp" onmouseover="changeOpacityIn(this);" onmouseout="changeOpacityOut(this);"></a> 
  	  </div>
EOL;
	  }
?>
  </body>
</html>