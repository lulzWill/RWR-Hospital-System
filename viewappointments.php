<?php
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	include_once('navbar.php');

	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	ParseClient::setStorage( new ParseSessionStorage() );
	$currentUser = ParseUser::getCurrentUser();
	$currentUser->save();
	
	if(!$currentUser)
	{
		header("Location: index.php");
		exit;
		
	}
	if($currentUser->get("position") == "patient")
	{
		echo <<<EOL
  <!DOCTYPE html>
  <html lang="en">
  <head>
  	<title>
  		View My Appointments
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="editprofile.css" rel="stylesheet">
	<link href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
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

    
	
	<!-- Include Parse Stuff -->
    <script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>

    <input hidden="true" id="currUserID" value='
EOL;
echo $currentUser->get("email");
echo <<<EOL
'/>
    </head>
  <body>
	<body>
		<h1>
			Current Appointments
		</h1>
		<table class="table table-hover table-bordered table-condensed table-striped" style="margin-left: 10%; width: 80% !important;">
	 		<tr class="active">
	 			<th class="active tableDiv">Date</th>
	 			<th class="active tableDiv">Time</th>
				<th class="active tableDiv">Doctor</th>
				<th class="active tableDiv">Doc Email</th>
				<th class="active tableDiv">Nurse</th>
				<th class="active tableDiv">Nurse Email</th>
				<th class="active tableDiv">Cancel Appointment</th>
				<th class="active tableDiv">Edit Appointment</th>
	 		</tr>
EOL;
	$query = new ParseQuery("appointments");
	$query->equalTo("patientEmail", $currentUser->get("email"));
	$results = $query->find();

	for ($i = 0; $i < count($results); $i++) 
	{ 
  		$object = $results[$i];

  		$innerQuery = new ParseQuery("Physician");
  		$innerQuery->equalTo("email", $object->get("physicianEmail"));

  		$innerResults = $innerQuery->find();

  		$nurseQuery = new ParseQuery("Nurse");
  		$nurseQuery->equalTo("email", $object->get("nurseEmail"));

  		$nurseResults = $nurseQuery->find();

  		echo '<tr class="active"  data-target="#basicModal" data-id =" '.$i.' " data-object-id=" '.$results[$i]->getObjectId().' " data-date =" '.$object->get("Date").' " data-time =" '.$object->get("Time").' "
  		 data-doctor =" ' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name") . ' " data-doctor-email="'. $object->get("physicianEmail") .'"
  		 data-nurse=" ' . $nurseResults[0]->get("first_name") . ' ' . $nurseResults[0]->get("last_name") . ' " data-nurse-email="' . $object->get("nurseEmail") . '"
		 data-specialty="' .$object->get("specialty"). '">';
	 	echo	'<td class="active tableDiv">' . $object->get("Date") . '</th>';
	 	echo	'<td class="active tableDiv">' . $object->get("Time") . '</th>';
		echo	'<td class="active tableDiv">Dr. ' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name") . '</th>';
		echo	'<td class="active tableDiv">' . $object->get("physicianEmail") . '</th>';
		echo	'<td class="active tableDiv">' . $nurseResults[0]->get("first_name") . ' ' . $nurseResults[0]->get("last_name") . '</th>';
		echo	'<td class="active tableDiv">' . $object->get("nurseEmail") . '</th>';
		echo    '<td class="active tableDiv">';
		echo <<<EOL
			<form method="POST" action="cancelappointment.php" id="object">
              <input type="hidden" class="form-control" name="objectid" id="objectid" value="
EOL;
echo $results[$i]->getObjectId();
echo <<<EOL
"> 

               <button type="submit" class="btn btn-danger">Cancel</button>
            </form>
EOL;
echo    '<td class="active tableDiv">';

echo '<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#basicModal">Reschedule</a>';
		echo    '</tr>';
	}
echo <<<EOL
		</table>


		

		
		<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Reschedule Appointment</h4>
		      </div>

		      <div class="modal-body">

		      <form class="form-horizontal" id="object" name="myForm" action="#">
		
				<div class="container">
				<div class="row">
				<!--
					<label for="currentObjectId" id="currentObjectId" nameclass="col-sm-12 control-label blacklabel"></label>
				-->
					<input type="hidden" id="currentObjectId2" name="currentObjectId2" class="form-control" value=''/>
				</div>
				</div>
				
				<div class="container">
				<div class="row">
					<label for="currentDate" id="currentDate" class="col-sm-12 control-label blacklabel" style="text-align: left;"></label>
					<input type="hidden" id="currentDate2" name="currentDate2" class="form-control" value=''/>
				</div>
				</div>

				<div class="container">
				<div class="row">
					<label for="currentTime" id="currentTime" class="col-sm-12 control-label blacklabel" style="text-align: left;">current time: </label>
					<input type="hidden" id="currentTime2" name="currentTime2" class="form-control" value=''/>
				</div>
				</div>

				<div class="container">
				<div class="row">
					<label for="currentDoctor" id="currentDoctor" class="col-sm-12 control-label blacklabel" style="text-align: left;">current doctor: </label>
					<input type="hidden" id="currentDoctor2" name="currentDoctor2" class="form-control" value=''/>
				</div>
				</div>
				
				<div class="container">
				<div class="row">
					<label for="specialty" id="specialty" class="col-sm-12 control-label blacklabel" style="text-align: left;">Specialty: </label>
					<input type="hidden" id="specialty2" name="specialty2" class="form-control" value=''/>
				</div>
				</div>
				
				<div class="container">
				<div class="row">
				<!--
					<label for="currentDoctorEmail" id="currentDoctorEmail" class="col-sm-12 control-label blacklabel">current doc email: </label>
				-->
					<input type="hidden" id="currentDoctorEmail2" name="currentDoctorEmail2" class="form-control" value=''/>
				</div>
				</div>
				
				<div class="container">
				<div class="row">
					<label for="currentNurse" id="currentNurse" class="col-sm-12 control-label blacklabel" style="text-align: left; margin-bottom: 5px;">current nurse: </label>
					<input type="hidden" id="currentNurse2" name="currentNurse2" class="form-control" value=''/>
				</div>
				</div>
				
				<div class="container">
				<div class="row">
				<!--
					<label for="currentNurseEmail" id="currentNurseEmail" class="col-sm-12 control-label blacklabel">current nurse email: </label>
				-->	
					<input type="hidden" id="currentNurseEmail2" name="currentNurseEmail2" class="form-control" value=''/>
				</div>
				</div>
				


		        

		        

				<div class="form-group">
				  <label class="col-md-2 control-label" for="selectDate">Select a New Date</label>
				  <div class="col-md-10">
				    <select id="selectDate" name="selectDate" class="form-control" onChange="dateChange()">
EOL;
/*
								$query = new ParseQuery("appointments");
								$query->equalTo("patientEmail", $currentUser->get("email"));
								$results = $query->find();

								for ($i = 0; $i < count($results); $i++) { 
							  		$object = $results[$i];

							  		$innerQuery = new ParseQuery("Physician");
							  		$innerQuery->equalTo("email", $object->get("physicianEmail"));

							  		$innerResults = $innerQuery->find();
							  	}
*/
				            	//$query = new ParseQuery("Specialties");
				            	$query = new ParseQuery("appointments");
								$query->equalTo("patientEmail", $currentUser->get("email"));
				            	$results = $query->find();



				            	for($i = 0; $i < count($results); $i++)
				            	{

				            		$object = $results[$i];

				            		$innerQuery = new ParseQuery("appointments");
							  		$innerQuery->equalTo("available", "true");
							  		$innerQuery->equalTo("physicianEmail", $results[$i]->get("physicianEmail"));
							  		$innerQuery->ascending("Date");

							  		$innerResults = $innerQuery->find();

							  		for($j = 0; $j < count($innerResults); $j++)
				            		{
				            			//echo("<script>console.log('innerDate: ".$innerResults[$j]->get("Date")."');</script>");
							  			//echo("<script>console.log('innerTime: ".$innerResults[$j]->get("Time")."');</script>");

				            			/*
							  			echo '<option value="'; echo $innerResults[$j]->get("Date"); echo ' '; echo $innerResults[$j]->get("Time"); echo '">';
							  			 echo $innerResults[$j]->get("Date");
							  			 echo '  --  ';
							  			 echo $innerResults[$j]->get("Time");
							  			echo '</option>';
							  			*/

							  			echo '<option value="'; echo $innerResults[$j]->get("Date"); echo '">';
							  			 echo $innerResults[$j]->get("Date");
							  			echo '</option>';
							  		}

							  		

				            	}

				            	


				            	echo <<<EOL
				    </select>
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-2 control-label" for="selectTime">Select a New Time</label>
				  <div class="col-md-10">
				    <select id="selectTime" name="selectTime" class="form-control" disabled="true">


				    </select>
				  </div>
				</div>

				
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <input type="button" class="btn btn-primary" onclick="Update()" value="Save Changes"/>
		      </div>
		      </form>
		    </div>
		  </div>
		</div>
	
		

	</body>




	<script type="text/javascript">

		function dateChange() {

			removeOptions(document.getElementById("selectTime"));


			document.getElementById("selectTime").disabled = false;
			var myDate = document.getElementById("selectDate").value;
			var myDoctor = document.getElementById("currentDoctorEmail2").value;
			//console.log(myDoctor);
			//console.log( JSON.stringify(myDoctor) );

			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

			var appt = Parse.Object.extend("appointments");
			var query = new Parse.Query(appt);
			
			query.equalTo("Date", myDate);
			query.equalTo("available", "true");
			//query.equalTo("physicianEmail", myDoctor);
			query.ascending("Time");

			var option = document.createElement("option");
			option.label = "Choose one";
			document.getElementById("selectTime").add(option);

			query.find({
					  success: function(results) {
					  	for(var i = 0; i < results.length; i++)
					  	{
					  		var option = document.createElement("option");
					  		option.label = results[i].get("Time");
					  		option.value = results[i].get("Time");
					  		document.getElementById("selectTime").add(option);
					  	}
					  },
					  error: function(error) {
					    alert("Error: " + error.code + " " + error.message);
					  }
			});

		}

		function removeOptions(selectbox)
		{
		    var i;
		    for(i=selectbox.options.length-1;i>=0;i--)
		    {
		        selectbox.remove(i);
		    }
		}

		function Update(){
			var currentUser = Parse.User.current();
        	var getID = document.getElementById("objectid").value;
        	var getDate = document.getElementById("currentDate2").value;
        	var getTime = document.getElementById("currentTime2").value;
        	var getDoctorEmail = document.getElementById("currentDoctorEmail2").value;
        	var getNurseEamil = document.getElementById("currentNurseEmail2").value;
			var getSpecialty = document.getElementById("specialty2").value;
        	var newDate = document.getElementById("selectDate").value;
        	var newTime = document.getElementById("selectTime").value;
        	
        	
        	Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");



        	// update old appt to available
        	
			var appt = Parse.Object.extend("appointments");
			var query = new Parse.Query(appt);
			query.equalTo("objectId", getID);
			query.first({
			  success: function(object) {

				    object.set("available", "true");

				    object.unset("patientEmail");
				    object.unset("nurseEmail");
				    object.unset("specialty");


					object.save(null, {
			  			success: function(object) {
			    			// Execute any logic that should take place after the object is saved.console.log("updated old");
		          			// update new appt to taken

							var newAppt = Parse.Object.extend("appointments");
							var query2 = new Parse.Query(newAppt);
							console.log(newDate);
							console.log(newTime);
							console.log(getDoctorEmail);
							query2.equalTo("Date", newDate);
							query2.equalTo("Time", newTime);
							query2.equalTo("physicianEmail", getDoctorEmail);
							query2.first({
					  			success: function(object) {

								    object.set("available", "taken");
								    //TODO set current nurse email
								    console.log(object);
									//object.set("specialty", getSpecialty).value)
								    object.set("nurseEmail", "none@none.com");
								    object.set("patientEmail", document.getElementById("currUserID").value);

								    object.save(null, {
									  success: function(object) {
									    // Execute any logic that should take place after the object is saved.
									    console.log("updated new");
									    location.reload();
									  },
									  error: function(object, error) {
									    // Execute any logic that should take place if the save fails.
									    // error is a Parse.Error with an error code and message.
									    alert('Failed to create new object, with error code: ' + error.message);
									  }
									});
								}
							});
			  			},
						  error: function(object, error) {
						    // Execute any logic that should take place if the save fails.
						    // error is a Parse.Error with an error code and message.
						    alert('Failed to create new object, with error code: ' + error.message);
						  }

		    		});

			},
			  error: function(error) {
			    alert("Error: " + error.code + " " + error.message);
			  }
			});
		


			

			
			
    	}

		$(function(){
		

			$('#basicModal').modal({
				show:false

			    }).on('show.bs.modal', function() {
			        var getIdFromRow = $(event.target).closest('tr').data('object-id'); //get the id from tr
			        
			        $(this).find('#currentObjectId').html($('<b> current objID: ' + getIdFromRow  + '</b>'));
			        $(this).find('#currentObjectId2').val(getIdFromRow);

			        var date = $(event.target).closest('tr').data('date');
			        $(this).find('#currentDate').html($('<b> Current date: ' + date  + '</b>'));
			        $(this).find('#currentDate2').val(date);

			        var time = $(event.target).closest('tr').data('time');
			        $(this).find('#currentTime').html($('<b> Current time: ' + time  + '</b>'));
			        $(this).find('#currentTime2').val(time);

			        var doctor = $(event.target).closest('tr').data('doctor');
			        $(this).find('#currentDoctor').html($('<b> Current doctor: ' + doctor  + '</b>'));
			        $(this).find('#currentDoctor2').val(doctor);

			        var doctorEmail = $(event.target).closest('tr').data('doctor-email');
			        $(this).find('#currentDoctorEmail').html($('<b> current doc email: ' + doctorEmail  + '</b>'));
			        $(this).find('#currentDoctorEmail2').val(doctorEmail);

			        var nurse = $(event.target).closest('tr').data('nurse');
			        $(this).find('#currentNurse').html($('<b> Current nurse: ' + nurse  + '</b>'));
			        $(this).find('#currentNurse2').val(nurse);

			        var nurseEmail = $(event.target).closest('tr').data('nurse-email');
			        $(this).find('#currentNurseEmail').html($('<b> current nurse email: ' + nurseEmail  + '</b>'));
			        $(this).find('#currentNurseEmail2').val(nurseEmail);

			});
		});


	</script>


</html>
EOL;
	}
	else if($currentUser->get("position") == "nurse")
	{
		echo <<<EOL
  <!DOCTYPE html>
  <html lang="en">
  <head>
  	<title>
  		Edit Profile Page
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="editprofile.css" rel="stylesheet">
	<link href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

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
	<script language="javascript"> 
	
    </head>
  <body>
	<body>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
		<h1>
			Current Appointments
		</h1>
		<table class="table table-hover table-bordered table-condensed" style="margin-left: 10%; width: 80% !important;">
	 		<tr class="active">
	 			<th class="active tableDiv">Date</th>
	 			<th class="active tableDiv">Time</th>
				<th class="active tableDiv">Department</th>
				<th class="active tableDiv">Doctor</th>
				<th class="active tableDiv">Patient</th>
				<th class="active tableDiv">Link to Profile</th>
	 		</tr>
EOL;
	$query = new ParseQuery("appointments");
	$query->equalTo("nurseEmail", $currentUser->get("email"));
	$query->equalTo("available", "taken");
	$results = $query->find();

	for ($i = 0; $i < count($results); $i++) { 
	
  		$object = $results[$i];

  		$innerQuery = new ParseQuery("Patient");
  		$innerQuery->equalTo("email", $object->get("patientEmail"));
		$innerResults = $innerQuery->find();
		
		$innerQuery2 = new ParseQuery("Physician");
  		$innerQuery2->equalTo("email", $object->get("physicianEmail"));
		$innerResults2 = $innerQuery2->find();
		
	 	echo	'<td class="active tableDiv">' . $object->get("Date") . '</th>';
	 	echo	'<td class="active tableDiv">' . $object->get("Time") . '</th>';
		echo	'<td class="active tableDiv">' . $object->get("specialty") . '</th>';
		echo	'<td class="active tableDiv">Doctor ' . $innerResults2[0]->get("first_name") . ' ' . $innerResults2[0]->get("last_name"). '</th>';
		echo	'<td class="active tableDiv">Patient ' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name"). '</th>';
		echo    '<td class="active tableDiv">';
echo <<<EOL
<form method="POST" action="patientsearch.php" id="patientsearch">
              <input type="hidden" class="form-control" name="patientemail" id="patientemail" value="
EOL;
echo $object->get("patientEmail");
echo <<<EOL
"> 
               <button type="submit" class="btn btn-info">View Patient's Profile</button>
            </form>
		</th>
EOL;
echo <<<EOL
		</tr>
EOL;
	}
echo <<<EOL
		</table>
		
	</body>
</html>
EOL;
	}
	if($currentUser->get("position") == "physician")
	{
		echo <<<EOL
  <!DOCTYPE html>
  <html lang="en">
  <head>
  	<title>
  		Edit Profile Page
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="editprofile.css" rel="stylesheet">
	<link href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

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
	<script language="javascript"> 
	
    </head>
  <body>
	<body>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
		<h1>
			Current Appointments
		</h1>
		<table class="table table-hover table-bordered table-condensed" style="margin-left: 10%; width: 80% !important;">
	 		<tr class="active">
	 			<th class="active tableDiv">Date</th>
	 			<th class="active tableDiv">Time</th>
				<th class="active tableDiv">Specialty</th>
				<th class="active tableDiv">Nurse</th>
				<th class="active tableDiv">Patient</th>
				<th class="active tableDiv">Link to Profile</th>
				<th class="active tableDiv">Cancel Appointment</th>
				<th class="active tableDiv">Appt Status</th>
				<th class="active tableDiv">Price</th>
				<th class="active tableDiv">Bill</th>
	 		</tr>
EOL;
	$query = new ParseQuery("appointments");
	$query->equalTo("physicianEmail", $currentUser->get("email"));
	$query->containedIn("available", ["taken", "complete"]);
	$results = $query->find();

	for ($i = 0; $i < count($results); $i++) { 
	
  		$object = $results[$i];
  		$innerQuery = new ParseQuery("Patient");
  		$innerQuery->equalTo("email", $object->get("patientEmail"));
  		$innerResults = $innerQuery->find();
		
		$innerQuery2 = new ParseQuery("Nurse");
  		$innerQuery2->equalTo("email", $object->get("nurseEmail"));
  		$innerResults2 = $innerQuery2->find();
		
	 	echo	'<td class="active tableDiv">' . $object->get("Date") . '</th>';
	 	echo	'<td class="active tableDiv">' . $object->get("Time") . '</th>';
		echo	'<td class="active tableDiv">' . $object->get("specialty") . '</th>';
		echo    '<td class="active tableDiv">' . $innerResults2[0]->get("first_name") . ' ' . $innerResults2[0]->get("last_name") . '</th>';
		echo	'<td class="active tableDiv">Patient ' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name"). '</th>';
		echo    '<td class="active tableDiv">';
echo <<<EOL
<form method="POST" action="patientsearch.php" id="patientsearch">
              <input type="hidden" class="form-control" name="patientemail" id="patientemail" value="
EOL;
echo $object->get("patientEmail");
echo <<<EOL
"> 
               <button type="submit" class="btn btn-info">Patient's Profile</button>
            </form>
		</th>
EOL;
		echo    '<td class="active tableDiv">';
echo <<<EOL
<form method="POST" action="cancelappointment.php" id="object">
              <input type="hidden" class="form-control" name="objectid" id="objectid" value="
EOL;
echo $results[$i]->getObjectId();
echo <<<EOL
"> 
               <button type="submit" class="btn btn-danger">Cancel Appointment</button>
            </form>
		</th>
EOL;
if($object->get("available")== "taken")
{
	echo    '<td class="active tableDiv">';
	echo <<<EOL
			<form method="POST" action="complete.php" id="object">
			   <input type="hidden" class="form-control" name="status" id="status" value="complete">
              <input type="hidden" class="form-control" name="objectid" id="objectid" value="
EOL;
echo $results[$i]->getObjectId();
echo <<<EOL
"> 
               <button type="submit" class="btn btn-warning">Incomplete</button>
            </form>
		</th>
EOL;
}
else if($object->get("available")=="complete")
{
	echo    '<td class="active tableDiv">';
	echo <<<EOL
			<form method="POST" action="complete.php" id="object">
			  <input type="hidden" class="form-control" name="status" id="status" value="taken">
              <input type="hidden" class="form-control" name="objectid" id="objectid" value="
EOL;
echo $results[$i]->getObjectId();
echo <<<EOL
"> 
               <button type="submit" class="btn btn-success">Complete</button>
            </form>
		</th>
EOL;
}

echo    '<td class="active tableDiv">' . $object->get("price") . '</th>';
echo    '<td class="active tableDiv">' . $object->get("paymentStatus") . '</th>';
		
echo <<<EOL
		</tr>
EOL;
	}
echo <<<EOL
		</table>
		
	</body>
</html>
EOL;
}
?>