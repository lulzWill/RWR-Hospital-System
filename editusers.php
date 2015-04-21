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
	if($currentUser->get("position") == "admin")
	{
		echo <<<EOL
  <!DOCTYPE html>
  <html lang="en">
  <head>
  	<title>
  		Edit Users
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="editAdminprofile.css" rel="stylesheet">
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
			Users
		</h1>
		<table class="table table-hover table-bordered table-condensed table-striped" style="margin-left: 10%; width: 80% !important;">
	 		<tr class="active">
	 			<th class="active tableDiv">Name</th>
	 			<th class="active tableDiv">Email</th>
				<th class="active tableDiv">Position</th>
				<th class="active tableDiv">Edit User</th>
	 		</tr>
EOL;
	$query = ParseUser::query();
	$query->equalTo("emailVerified", true);
	$query->ascending("lastname");
	$results = $query->find();

	for ($i = 0; $i < count($results); $i++) 
	{ 
  		$object = $results[$i];

  		echo '<tr class="active"  data-target="#basicModal" data-id =" '.$i.' " data-object-id="'.$object->getObjectId().' " data-name ="'.$object->get("firstname").' '.$object->get("lastname").'" data-email ="'.$object->get("email").'"
  		data-position="'. $object->get("position") .'" ">';
	 	echo	'<td class="active tableDiv">' . $object->get("lastname") . ', ' . $object->get("firstname") .'</th>';
	 	echo	'<td class="active tableDiv">' . $object->get("email") . '</th>';
		echo	'<td class="active tableDiv">' . $object->get("position") . '</th>';
		echo    '<td class="active tableDiv">';

echo '<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#'. $object->get("position") .'Modal" data-email="'.$object->get("email").'">Edit User</a>';
		echo    '</tr>';
	}
echo <<<EOL
		</table>
		
		<div class="modal fade" id="physicianModal" tabindex="-1" role="dialog" aria-labelledby="physicianModal" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="physModalLabel">Edit Physician</h4>
		      </div>

		      <div class="modal-body">
		      	<form class="form-horizontal" action="" method="" id="editProfile1" onsubmit="return validateForm()">
					<div class="profpic">
						<h4>User Information</h4>
						<div class="container">
						<div class="row">
							<div class="col-sm-10">
								<input type="hidden" class="form-control" id="email" name="email" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="firstName" class="col-sm-2 control-label whitelabel">First Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="firstName" name="firstName" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="lastName" class="col-sm-2 control-label whitelabel">Last Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="lastName" name="lastName" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="bday" class="col-sm-2 control-label whitelabel">Birthday:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="bday" name="bday" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="role" class="col-sm-2 control-label whitelabel">Position:</label>
							<div class="col-sm-10 selectContainer">
					            <select class="form-control" name="role" id="role" required>
					                <option value="nurse">Nurse</option>
					                <option value="admin">Administrator</option>
					                <option value="patient">Patient</option>
					                <option value="physician">Physician</option>
					            </select>
					        </div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="sex" class="col-sm-2 control-label whitelabel">Sex:</label>
							<div class="col-sm-10">
								<select class="form-control" name="sex" id="sex" name="sex" required>
					                <option value="Male">Male</option>
					                <option value="Female">Female</option>
					            </select>
							</div>
						</div>
						</div>
						<h4>Profile Picture</h4>
						<div class="container">
						<div class="row">
							<label for="prof_pic" class="col-sm-2 control-label whitelabel">Prof. Pic:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="prof_pic" name="prof_pic" align="left" value="" required>
			                </div>			
						</div>
						</div>
					</div>
					<div class="continfo">
						<h4>Physician Information</h4>
						<div class="container">
						<div class="row">
							<label for="degree" class="col-sm-2 control-label whitelabel">Degree:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="degree" name="degree" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="school" class="col-sm-2 control-label whitelabel">University:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="school" name="school" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="experience" class="col-sm-2 control-label whitelabel">Years of Experience:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="experience" name="experience" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="address" class="col-sm-2 control-label whitelabel">Work Address:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="address" name="address" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="citystate" class="col-sm-2 control-label whitelabel">City, State:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="citystate" name="citystate" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="zipcode" class="col-sm-2 control-label whitelabel">Zipcode:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="zipcode" name="zipcode" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="phone" class="col-sm-2 control-label whitelabel">Work/Office Phone:</label>
							<div class="col-sm-10">
								<input type="text" size="20" class="form-control" id="phone" name="phone" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<input type="button" class="btn btn-primary pull-right" onclick="UpdatePhys()" value="Save Changes"/>
						</div>
						</div>
					</div>
					</form>
			  </div>	
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		      </form>
		    </div>
		  </div>
		</div>

		<div class="modal fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModal" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Edit Patient</h4>
		      </div>

		      <div class="modal-body">

			  </div>

				
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <input type="button" class="btn btn-primary" onclick="Update()" value="Save Changes"/>
		      </div>
		      </form>
		    </div>
		  </div>
		</div>

		<div class="modal fade" id="nurseModal" tabindex="-1" role="dialog" aria-labelledby="nurseModal" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Edit Nurse</h4>
		      </div>

		      <div class="modal-body">

			  </div>

				
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <input type="button" class="btn btn-primary" onclick="Update()" value="Save Changes"/>
		      </div>
		      </form>
		    </div>
		  </div>
		</div>

		<div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModal" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Edit Admin</h4>
		      </div>

		      <div class="modal-body">

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


		function Update(){
			var currentUser = Parse.User.current();
        	var getID = document.getElementById("objectid").value;
        	var getDate = document.getElementById("currentDate2").value;
        	var getTime = document.getElementById("currentTime2").value;
        	var getDoctorEmail = document.getElementById("currentDoctorEmail2").value;
        	var getNurseEamil = document.getElementById("currentNurseEmail2").value;
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

				    object.set("patientEmail", "(undefined)");
				    object.set("nurseEmail", "(undefined)");
				    object.set("specialty", "(undefined)");


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
    	function UpdatePhys()
    	{
    		Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

			var usr = Parse.Object.extend("Physician");
			var query = new Parse.Query(usr);
			var curEmail = document.getElementById("email").value;

			query.equalTo("email", curEmail);
			query.first({
					  success: function(object) {
					  		
					  		//object.set("prof_pic", document.getElementById("prof_pic").value);
					  		object.set("degree", document.getElementById("degree").value);
					  		object.set("school", document.getElementById("school").value);
					  		object.set("experience", document.getElementById("experience").value);
					  		object.set("address", document.getElementById("address").value);
					  		object.set("citystate", document.getElementById("citystate").value);
					  		object.set("zipcode", document.getElementById("zipcode").value);
					  		object.set("phone", document.getElementById("phone").value);

					  		object.save(null, {
					  				success: function(object) {
					  					alert("Changes have been successfully made!");
					  					location.reload();
						    			//would update user data if that were possible with parse... parse sucks
/*
										var usr = Parse.Object.extend("User");
										var query = new Parse.Query(usr);
										query.equalTo("email", curEmail);
										query.first({
							  			success: function(object) {

										    object.set("firstname", document.getElementById("firstName").value);
											object.set("lastname", document.getElementById("lastName").value);
											object.set("dateOfBirth", document.getElementById("bday").value);
											object.set("position", document.getElementById("role").value);
											object.set("sex", document.getElementById("sex").value);
										    
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
*/
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
			$('#physicianModal').modal({
				show:false

			    }).on('show.bs.modal', function(event) {
			    	Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

			    	var usr = Parse.Object.extend("Physician");
					var query = new Parse.Query(usr);
					var curEmail = $(event.relatedTarget).data('email');

					query.equalTo("email", curEmail);
					query.first({
					  success: function(object) {
					  		document.getElementById("prof_pic").value = object.get("prof_pic").url();
					  		document.getElementById("email").value = object.get("email");
					  		document.getElementById("degree").value = object.get("degree");
					  		document.getElementById("school").value = object.get("school");
					  		document.getElementById("experience").value = object.get("experience");
					  		document.getElementById("address").value = object.get("address");
					  		document.getElementById("citystate").value = object.get("citystate");
					  		document.getElementById("zipcode").value = object.get("zipcode");
					  		document.getElementById("phone").value = object.get("phone");

					  		var usr = Parse.Object.extend("User");
							var query = new Parse.Query(usr);
							query.equalTo("email", curEmail);
							query.first({
								success: function(object) {
									document.getElementById("firstName").value = object.get("firstname");
									document.getElementById("lastName").value = object.get("lastname");
									document.getElementById("bday").value = object.get("dateOfBirth");
									document.getElementById("role").value = object.get("position");
									document.getElementById("sex").value = object.get("sex");
									document.getElementById("physModalLabel").innerHTML = "Edit Physician - " + object.get("firstname") + " " + object.get("lastname");
								},
								error: function(error) {
									alert("Error: " + error.code + " " + error.message);
								}
							})

					},
					  error: function(error) {
					    alert("Error: " + error.code + " " + error.message);
					  }
					});	
			});
		});

		$(function(){
			$('#patientModal').modal({
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

		$(function(){
			$('#nurseModal').modal({
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

		$(function(){
			$('#adminModal').modal({
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
	else 
	{
		header("Location: index.php");
	}
?>