<?php
	include_once("navbar.php");
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	ParseClient::setStorage( new ParseSessionStorage() );
	
	$currentUser = ParseUser::getCurrentUser();
	
	if(!$currentUser)
	{
		header("Location: index.php");
		exit;
		
	}
	echo <<<EOL

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

    <link rel="stylesheet" href="bower_components/bootstrap-calendar/css/calendar.css">

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


	<script type="text/javascript" src="bower_components/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
  <link rel="stylesheet" href="css/calendar.css">
  <link href="makeappointment.css" rel="stylesheet">
  </head>
  
  <body>
	<div style="position: relative; top: 5%; left: 30%; width: 70%; font-weight: bold; font-size: 32px; color: white; margin-bottom: 20px;">
		<p>RWR Hospital Management System</p>
	</div>
	  
	<div class="panel panel-default" style="margin-left: 12%; margin-right: 12%;">
  		<div class="panel-body">  
			<form class="form-inline" method="POST" action="scheduleApt.php" name="scheduleApt" id="scheduleApt">
				<div class="form-group">
					<label for="specialty" class="col-sm-12 control-label blacklabel">Select a Specialization:</label>
					<div class="col-sm-10 selectContainer">
						<select class="form-control" id="specialty" name="specialty" onchange="fillPhysicians()" required>
						    <option value="">Choose one</option>
EOL;
				            	$query = new ParseQuery("Specialties");
				            	$results = $query->find();

				            	for($i = 0; $i < count($results); $i++)
				            	{
				            		echo '<option value="'; echo $results[$i]->get("name"); echo '">'; echo $results[$i]->get("name"); echo '</option>';
				            	}

				            	echo <<<EOL
				        </select>
					</div>
				</div>
				<div class="form-group">
					<label for="doctor" class="col-sm-12 control-label blacklabel">Select a Physician:</label>
					<div class="col-sm-10 selectContainer">
						<select class="form-control" name="doctorSelect" id="doctorSelect" onchange="docChanged()" disabled="true" required>
						    <option value="">Select a Doctor</option>
				        </select>
				        <!-- Button trigger modal -->
						<button type="button" class="btn btn-primary btn-med" data-toggle="modal" data-target="#docModal" disabled="true" id="docModalBTN">
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						</button>

						<!-- Modal -->
						<div class="modal fade" id="docModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="docModalLbl">Modal title</h4>
						      </div>
						      <div class="modal-body" id="docInfoDiv">
						        ...
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
						      </div>
						    </div>
						  </div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="time" class="col-sm-12 control-label blacklabel">Select a Time:</label>
					<div class="col-sm-10 selectContainer">
						<select class="form-control" name="timeSelect" id="timeSelect" onchange="dateChange()" disabled="true" required>
						    <option value="">Choose one</option>
				        </select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10 selectContainer" hidden="true">
						<select class="form-control" name="dateSel" id="dateSel" onchange="" required>
						    <option value="">Choose one</option>
				        </select>
					</div>
				</div>
				</br>
				<button type="submit" class="btn btn-primary col-sm-2 pull-right">Schedule Appointment</button>
			</form>
		</div>
	</div>

EOL;
echo <<<EOL

    <script type="text/javascript">

    	function dateChange()
    	{
    		document.getElementById("dateSel").selectedIndex = document.getElementById("timeSelect").selectedIndex;
    	}

    	function fillPhysicians()
			{
				Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
				
				var Physician = Parse.Object.extend("Physician");
				var query = new Parse.Query(Physician);
				
				var d = document.forms["scheduleApt"]["specialty"].value;

				query.equalTo("specialties", d);
				document.scheduleApt.doctorSelect.options.length = 0;
				var option = document.createElement("option");
				option.label = "Select a Doctor";
				document.scheduleApt.doctorSelect.add(option);

				query.find({
					  success: function(results) {
					  	for(var i = 0; i < results.length; i++)
					  	{
					  		var option = document.createElement("option");
					  		option.label = results[i].get("last_name");
					  		option.value = results[i].get("email");
					  		document.scheduleApt.doctorSelect.add(option);
					  	}
					  },
					  error: function(error) {
					    alert("Error: " + error.code + " " + error.message);
					  }
				});

				if(document.scheduleApt.specialty.selectedIndex != 0)
				{
					document.scheduleApt.doctorSelect.disabled = false;
					document.getElementById("timeSelect").disabled = false;
				}
				else
				{
					document.scheduleApt.doctorSelect.disabled = true;
					document.getElementById("timeSelect").disabled = true;
				}
				if(document.scheduleApt.doctorSelect.selectedIndex != 0)
				{
					document.getElementById("docModalBTN").disabled = false;
				}
				else
				{
					document.getElementById("docModalBTN").disabled = true;
				}
			}

			function docChanged() {
				Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

				var Physician = Parse.Object.extend("Physician");
				var query = new Parse.Query(Physician);

				var d = document.forms["scheduleApt"]["doctorSelect"].value;

				query.equalTo("email", d);

				query.find({
					  success: function(results) {
					  	Physician = results[0];
					  	document.getElementById("docModalLbl").innerHTML = "Doctor " + Physician.get("first_name") + " " + Physician.get("last_name");

					  	document.getElementById("docInfoDiv").innerHTML = '<img height="65%" width="65%" src="' + Physician.get("prof_pic").url() + '"></br>Name: ' + Physician.get("first_name") + " " + Physician.get("last_name") +
					  														'</br>Years of Experience: ' + Physician.get("experience") +
					  														'</br>Degree: ' + Physician.get("degree") +
					  														'</br>School: ' + Physician.get("school") +
					  														'</br></br>Phone: ' + Physician.get("phone") +
					  														'</br>Location: ' + Physician.get("address");


					  },
					  error: function(error) {
					    alert("Error: " + error.code + " " + error.message);
					  }
				});

				var appt = Parse.Object.extend("appointments");
				var query = new Parse.Query(appt);

				var d = document.forms["scheduleApt"]["doctorSelect"].value;

				query.equalTo("physicianEmail", d);
				query.ascending("Date");
				
				document.scheduleApt.timeSelect.options.length = 0;
				var option = document.createElement("option");
				option.label = "Choose one";
				document.scheduleApt.timeSelect.add(option);

				query.find({
					  success: function(results) {
					  	for(var i = 0; i < results.length; i++)
					  	{
					  		if(results[i].get("available") == "true")
					  		{
					  			var option = document.createElement("option");
					  			option.label = results[i].get("Date") + " - " + results[i].get("Time");
					  			option.value = results[i].get("Time");
					  			document.scheduleApt.timeSelect.add(option);

					  			var option = document.createElement("option");
					  			option.label = results[i].get("Date") + " - " + results[i].get("Time");
					  			option.value = results[i].get("Date");
					  			document.scheduleApt.dateSel.add(option);
					  		}
					  	}
					  },
					  error: function(error) {
					    alert("Error: " + error.code + " " + error.message);
					  }
				});

				if(document.scheduleApt.doctorSelect.selectedIndex != 0)
				{
					document.getElementById("docModalBTN").disabled = false;
					document.getElementById("timeSelect").disabled = false;
				}
				else
				{
					document.getElementById("docModalBTN").disabled = true;
					document.getElementById("timeSelect").disabled = true;
				}
			}
			$(document).ready(function() {

				$('#dateRangePicker')
			        .datepicker({
			            format: 'mm/dd/yyyy',
			            startDate: '01/01/1910',

			            /*
			            var today = new Date();
						var dd = today.getDate();
						var mm = today.getMonth()+1; //January is 0!
						var yyyy = today.getFullYear();

						if(dd<10) {
						    dd='0'+dd
						} 

						if(mm<10) {
						    mm='0'+mm
						} 

						today = mm+'/'+dd+'/'+yyyy;
						*/
			            endDate: '12/30/2020'
			            //endDate: today
			        })
			        .on('changeDate', function(e) {
			            // Revalidate the date field
			            $('#dateRangeForm').formValidation('revalidateField', 'date');
			        });

			    $('#dateRangeForm').formValidation({
			        framework: 'bootstrap',
			        icon: {
			            valid: 'glyphicon glyphicon-ok',
			            invalid: 'glyphicon glyphicon-remove',
			            validating: 'glyphicon glyphicon-refresh'
			        },
			        fields: {
			            date: {
			                validators: {
			                    notEmpty: {
			                        message: 'The date is required'
			                    },
			                    date: {
			                        format: 'MM/DD/YYYY',
			                        min: '01/01/2010',
			                        max: '12/30/2020',
			                        message: 'The date is not a valid'
			                    }
			                }
			            }
			        }
			    });


				$('#apptButton').on('click', function (e) {

     				var date1 = $("#datetimepicker12").data("datetimepicker").getDate();
     				console.log(date1);
     				document.getElementById("closeButton").innerHTML= date1;

				});
			    

			});

			
		</script>

  </body>
</html>
EOL;
?>