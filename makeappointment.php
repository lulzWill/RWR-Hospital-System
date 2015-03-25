<?php
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	session_start();
	
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
  		Schedule Appointments
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="makeappointment.css" rel="stylesheet">
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

    <?php include_once("navbar.php"); ?>


	<!-- Include Parse Stuff -->
    <script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>

    <link rel="stylesheet" href="bower_components/bootstrap-calendar/css/calendar.css">

  </head>
  
  <body>
	<div style="position: relative; top: 5%; left: 30%; width: 70%; font-weight: bold; font-size: 32px; color: #fff; margin-bottom: 50px;">
		<p>RWR Hospital Management System</p>
	</div>
	  
	  
	<label for="doctor" class="col-sm-12 control-label whitelabel">Select a Physician:</label>
	<div class="col-sm-10 selectContainer">
		<select class="form-control" name="role" onchange="validateRole()" required>
		    <option value="">Choose one</option>
            <option value="physician">Physician</option>
            <option value="nurse">Nurse</option>
            <option value="admin">Administrator</option>
            <option value="patient">Patient</option>
        </select>
	</div>

	<script src="bower_components/underscore/underscore-min.js"></script>
	<script src="bower_components/bootstrap-calendar/js/calendar.min.js"></script>

	<div id="calendar"></div>

	<script type="text/javascript">
     var calendar = $("#calendar").calendar(
         {
             tmpl_path: "bower_components/bootstrap-calendar/tmpls/",
             events_source: function () { return []; }
         });
	</script>
		
		
	  

    <script>
    	function validateRole()
			{
				Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
				
				var loginKeys = Parse.Object.extend("signupKeys");
				var query = new Parse.Query(loginKeys);
				
				var d = document.forms["signupForm"]["role"].value;
				if(d == "physician")
				{
					var physpass = prompt("Please Enter the Physician Creation Password", "");
					query.equalTo("position", "physician");
					query.find({
					  success: function(results) {
						var key = results[0].get("key");
						if(physpass != key)
						{
							document.forms["signupForm"]["role"].selectedIndex = 0;
						}
					  },
					  error: function(error) {
					    alert("Error: " + error.code + " " + error.message);
					  }
					});
				}
				else if(d == "nurse")
				{
					var nursepass = prompt("Please Enter the Nurse Creation Password", "");
					query.equalTo("position", "nurse");
					query.find({
					  success: function(results) {
						var key = results[0].get("key");
						if(nursepass != key)
						{
							document.forms["signupForm"]["role"].selectedIndex = 0;
						}
					  },
					  error: function(error) {
					    alert("Error: " + error.code + " " + error.message);
					  }
					});
				}
				else if(d == "admin")
				{
					var adminpass = prompt("Please Enter the Admin Creation Password", "");
					query.equalTo("position", "admin");
					query.find({
					  success: function(results) {
						var key = results[0].get("key");
						if(adminpass != key)
						{
							document.forms["signupForm"]["role"].selectedIndex = 0;
						}
					  },
					  error: function(error) {
					    alert("Error: " + error.code + " " + error.message);
					  }
					});
				}
			}
		</script>

  </body>
</html>