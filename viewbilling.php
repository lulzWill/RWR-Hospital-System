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
  		My Billing
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="billing.css" rel="stylesheet">
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

/*
	<input hidden="true" id="currUserName" value='
EOL;
echo $currentUser->get("firstname");
echo " ";
echo $currentUser->get("lastname");
echo <<<EOL
'/>

<input hidden="true" id="currUserBday" value='
EOL;
echo $currentUser->get("dateOfBirth");
echo <<<EOL
'/>

<input hidden="true" id="currUserSex" value='
EOL;
echo $currentUser->get("sex");
echo <<<EOL
'/>

<input hidden="true" id="currUserInsurance" value='
EOL;
echo $currentUser->get("insurance");
echo <<<EOL
'/>

<input hidden="true" id="currUserConditions" value='
EOL;
echo $currentUser->get("pre_conditions");
echo <<<EOL
'/>
*/
    </head>
  <body>
	<body>
		<h1 class="text-center">
			Billing History
		</h1>
		<table class="table table-hover table-bordered table-condensed table-striped" style="margin-left: auto; margin-right: auto; margin-top: 2%; width: 60% !important;">
	 		<tr class="active">
	 			<th class="active tableDiv">Date of Appointment</th>
				<th class="active tableDiv">Specialist Seen</th>
				<th class="active tableDiv">Payment Information</th>
	 		</tr>
EOL;
	$query = new ParseQuery("appointments");
	$query->equalTo("patientEmail", $currentUser->get("email"));
	$query->containedIn("available", ["approved"]);
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

  		echo '<tr class="active"  data-target="#basicModal" data-id =" '.$i.' " data-object-id="'.$results[$i]->getObjectId().'" data-date =" '.$object->get("Date").' " data-time =" '.$object->get("Time").' "
  		 data-doctor =" ' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name") . ' " data-doctor-email="'. $object->get("physicianEmail") .'"
  		 data-nurse=" ' . $nurseResults[0]->get("first_name") . ' ' . $nurseResults[0]->get("last_name") . ' " data-nurse-email" ' . $object->get("nurseEmail") . ' " data-payment-status ="'.$object->get("paymentStatus").'"
  		 data-reason ="'.$object->get("specialty").'" data-cost ="$'.number_format($object->get("apptprice")).'" data-notes ="'.$object->get("notes").'" data-notes-init ="'.$object->get("reason").'"
		 data-availability="'.$object->get("available").'">';
	 	echo	'<td class="active tableDiv">' . $object->get("Date") . '</th>';
		echo	'<td class="active tableDiv">Dr. ' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name") . '</th>';
		
echo    '<td class="active tableDiv">';

echo '<a href="#" class="btn btn-info" data-toggle="modal" data-target="#basicModal">View</a>';
		echo    '</tr>';
		echo <<<EOL

			
              <input type="hidden" class="form-control" name="objectid" id="objectid" value="
EOL;
echo $results[$i]->getObjectId();
echo <<<EOL
"> 

              
EOL;
	}
echo <<<EOL
		</table>

		<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Appointment Details</h4>
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
					<label for="apptReason" id="apptReason" class="col-sm-12 control-label blacklabel" style="text-align: left;"></label>
					<input type="hidden" id="apptReason2" name="apptReason2" class="form-control" value=''/>
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
					<label for="currentNurse" id="currentNurse" class="col-sm-12 control-label blacklabel" style="text-align: left; margin-bottom: 5px;">current nurse: </label>
					<input type="hidden" id="currentNurse2" name="currentNurse2" class="form-control" value=''/>
				</div>
				</div>

				<div class="container">
				<div class="row">
					<label for="apptNotesInit" id="apptNotesInit" class="col-sm-12 control-label blacklabel" style="text-align: left;"></label>
					<input type="hidden" id="apptNotesInit2" name="apptNotesInit2" class="form-control" value=''/>
				</div>
				</div>

				<div class="container">
				<div class="row">
					<label for="apptNotes" id="apptNotes" class="col-sm-12 control-label blacklabel" style="text-align: left;"></label>
					<input type="hidden" id="apptNotes2" name="apptNotes2" class="form-control" value=''/>
				</div>
				</div>


				<div class="container">
				<div class="row">
					<label for="apptCost" id="apptCost" class="col-sm-12 control-label blacklabel" style="text-align: left;"></label>
					<input type="hidden" id="apptCost2" name="apptCost2" class="form-control" value=''/>
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
				<!--
					<label for="currentNurseEmail" id="currentNurseEmail" class="col-sm-12 control-label blacklabel">current nurse email: </label>
				-->	
					<input type="hidden" id="currentNurseEmail2" name="currentNurseEmail2" class="form-control" value=''/>
				</div>
				</div>


				
	

				
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" id="closeBtn" data-dismiss="modal">Close</button>
		        <button type="button" onClick="redirect()" class="btn btn-info" id="invoiceBtn" data-dismiss="modal">View Invoice</button>
		        <!--
		        <input type="button" id="payButton" class="btn btn-success" onclick="Update()" value="Pay Now"/>
		        -->
		      </div>
		      </form>
		    </div>
		  </div>
		</div>
	
		
		<div id="hidden_form_container" style="display:none;"></div>
	</body>




	<script type="text/javascript">


		function redirect() {
			sessionStorage.setItem("aDate", document.getElementById("currentDate2").value);
			sessionStorage.setItem("aReason", document.getElementById("apptNotesInit2").value);
			sessionStorage.setItem("aNotes", document.getElementById("apptNotes2").value);
			sessionStorage.setItem("aCost", document.getElementById("apptCost2").value);
			sessionStorage.setItem("docName", document.getElementById("currentDoctor2").value);
			sessionStorage.setItem("docEmail", document.getElementById("currentDoctorEmail2").value);
			sessionStorage.setItem("apptID", document.getElementById("currentObjectId2").value);
			//$('#basicModal').modal('hide');
			window.location.href = "invoice.php";
		}

		function dateChange() {

			removeOptions(document.getElementById("selectTime"));


			document.getElementById("selectTime").disabled = false;
			var myDate = document.getElementById("selectDate").value;
			var myDoctor = document.getElementById("currentDoctorEmail2").value;

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
        	Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

			var currentUser = Parse.User.current();
        	var getID = document.getElementById("currentObjectId2").value;
        	// update appt to paid
			var appt = Parse.Object.extend("appointments");
			var query = new Parse.Query(appt);
			query.equalTo("objectId", getID);

			query.first({
			  success: function(object) {

				    object.set("paymentStatus", "paid");

					object.save(null, {
			  			success: function(object) {
							// update new appt to taken
							var theForm, newInput1, newInput2;
							// Start by creating a <form>
							theForm = document.createElement('form');
						  	theForm.action = 'notifyPaid.php';
						  	theForm.method = 'post';
						  	// Next create the <input>s in the form and give them names and values
							newInput1 = document.createElement('input');
						  	newInput1.type = 'hidden';
						  	newInput1.name = 'patientEmail';
						  	newInput1.value = object.get("patientEmail");
						  	newInput5 = document.createElement('input');
						  	newInput5.type = 'hidden';
						  	newInput5.name = 'aptPrice';
						  	newInput5.value = object.get("apptprice");
						  	newInput6 = document.createElement('input');
						  	newInput6.type = 'hidden';
						  	newInput6.name = 'aptDate';
						  	newInput6.value = object.get("Date");
						  	newInput7 = document.createElement('input');
						  	newInput7.type = 'hidden';
						  	newInput7.name = 'aptTime';
						  	newInput7.value = object.get("Time");
						  	// Now put everything together...
						  	theForm.appendChild(newInput1);
						  	theForm.appendChild(newInput5);
						  	theForm.appendChild(newInput6);
						  	theForm.appendChild(newInput7);
						  	// ...and it to the DOM...
						  	document.getElementById('hidden_form_container').appendChild(theForm);
						  	// ...and submit it
						  	document.getElementById('payButton').disabled = true;
						  	document.getElementById('payButton').value = "Please Wait";
						  	document.getElementById('closeBtn').disabled = true;
						  	theForm.submit();	
						  	location.reload();
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

    	function modalFill() {

    	}

		$(function(){
		

			$('#basicModal').modal({
				show:false

			    }).on('show.bs.modal', function() {
			        var getIdFromRow = $(event.target).closest('tr').data('object-id'); //get the id from tr
			        
			        $(this).find('#currentObjectId').html($('<b> current objID: ' + getIdFromRow  + '</b>'));
			        $(this).find('#currentObjectId2').val(getIdFromRow);

			        var date = $(event.target).closest('tr').data('date');
			        $(this).find('#currentDate').html($('<b> Appointment Date: ' + date  + '</b>'));
			        $(this).find('#currentDate2').val(date);
			        sessionStorage.setItem("date", date);

			        var time = $(event.target).closest('tr').data('time');
			        $(this).find('#currentTime').html($('<b> Appointment Time: ' + time  + '</b>'));
			        $(this).find('#currentTime2').val(time);


			        var reason = $(event.target).closest('tr').data('reason');
			        $(this).find('#apptReason').html($('<b> Reason for Apppointment: ' + reason  + '</b>'));
			        $(this).find('#apptReason2').val(reason);


			        var paymentStatus = $(event.target).closest('tr').data('payment-status');
			        var p = 'paid';
					var approved = $(event.target).closest('tr').data('availability');
			        var a = 'approved';
			        var cost = $(event.target).closest('tr').data('cost');
			        if (paymentStatus == p) {
			        	$(this).find('#apptCost').html($('<b> Payment Due: ' + ' PAID '  + '</b>'));
			        	$(this).find('#payButton').hide();
			        }
			        else if(approved == a) {
			        	$(this).find('#apptCost').html($('<b> Payment Due: ' + cost  + '</b>'));
			        	$(this).find('#payButton').show();
			        }
					else
					{
						$(this).find('#apptCost').html($('<b> Payment Due: ' + ' Awaiting Approval '  + '</b>'));
			        	$(this).find('#payButton').hide();
					}
			        $(this).find('#apptCost2').val(cost);

			        var notesInit = $(event.target).closest('tr').data('notes-init');
			        $(this).find('#apptNotesInit').html($('<b> Initial Apppointment Notes: ' + notesInit  + '</b>'));
			        $(this).find('#apptNotesInit2').val(notesInit);

			        var notes = $(event.target).closest('tr').data('notes');
			        $(this).find('#apptNotes').html($('<b> Apppointment Notes: ' + notes  + '</b>'));
			        $(this).find('#apptNotes2').val(notes);

			        var doctor = $(event.target).closest('tr').data('doctor');
			        $(this).find('#currentDoctor').html($('<b> Specialist: ' + doctor  + '</b>'));
			        $(this).find('#currentDoctor2').val(doctor);

			        var doctorEmail = $(event.target).closest('tr').data('doctor-email');
			        $(this).find('#currentDoctorEmail').html($('<b> current doc email: ' + doctorEmail  + '</b>'));
			        $(this).find('#currentDoctorEmail2').val(doctorEmail);

			        var nurse = $(event.target).closest('tr').data('nurse');
			        $(this).find('#currentNurse').html($('<b> Nursing: ' + nurse  + '</b>'));
			        $(this).find('#currentNurse2').val(nurse);

			        var nurseEmail = $(event.target).closest('tr').data('nurse-email');
			        $(this).find('#currentNurseEmail').html($('<b> current nurse email: ' + nurseEmail  + '</b>'));
			        $(this).find('#currentNurseEmail2').val(nurseEmail);

			        $('#basicModal').modal('hide');

			        redirect();

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
	 		</tr>
EOL;
	$query = new ParseQuery("appointments");
	$query->equalTo("physicianEmail", $currentUser->get("email"));
	$query->equalTo("available", "taken");
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
               <button type="submit" class="btn btn-info">View Patient's Profile</button>
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