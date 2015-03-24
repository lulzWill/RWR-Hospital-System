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
  		Home
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

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

    <!-- Include Bootstrap Datepicker -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

	<style type="text/css">
		/**
		 * Override feedback icon position
		 * See http://formvalidation.io/examples/adjusting-feedback-icon-position/
		 */
		#dateRangeForm .form-control-feedback {
		    top: 0;
		    right: -15px;
		}
		/* Adjust feedback icon position */
		#signupForm .selectContainer .form-control-feedback,
		#signupForm .inputGroupContainer .form-control-feedback {
		    right: -15px;
		}
	</style>

	<!-- Include Bootstrap Combobox -->
	<link rel="stylesheet" href="/vendor/bootstrap-combobox/css/bootstrap-combobox.css">

	<script src="/vendor/bootstrap-combobox/js/bootstrap-combobox.js"></script>
	
	<!-- Include Parse Stuff -->
    <script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>
  </head>
  
  <body>
	  <div style="position: relative; top: 5%; left: 30%; width: 70%; font-weight: bold; font-size: 32px; color: #fff; margin-bottom: 50px;">
		  	<p>RWR Hospital Management System</p>
	  </div>
	  
	  
				<label for="role" class="col-sm-2 control-label whitelabel">Select a Doctor:</label>
				<div class="col-sm-10 selectContainer">
		            <select class="form-control" name="role" onchange="validateRole()" required>
		                <option value="">Choose one</option>
		                <option value="physician">Physician</option>
		                <option value="nurse">Nurse</option>
		                <option value="admin">Administrator</option>
		                <option value="patient">Patient</option>
		            </select>
		        </div>
			
	  

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