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

  </head>
  
  <body>
	<div style="position: relative; top: 5%; left: 30%; width: 70%; font-weight: bold; font-size: 32px; color: white; margin-bottom: 20px;">
		<p>RWR Hospital Management System</p>
	</div>
	  
	  
	<label for="doctor" class="col-sm-12 control-label whitelabel" style="color: white;">Select a Physician:</label>
	<div class="col-sm-10 selectContainer">
		<select class="form-control" name="role" onchange="validateRole()" required>
		    <option value="">Choose one</option>
            <option value="physician">Physician</option>
            <option value="nurse">Nurse</option>
            <option value="admin">Administrator</option>
            <option value="patient">Patient</option>
        </select>
	</div>

	<a href="#" class="btn btn-info" data-toggle="modal" data-target="#basicModal">Make an Appointment</a>

	<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

	<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Select a Date & Time</h4>
	      </div>
	      <div class="modal-body">
	        <form class="form-horizontal" action="schedule.php" method="post" id="scheduleForm">
	        	<div class="form-group">
				<div class="container">
				    <div class="col-sm-6">
				        <div class="form-group">
				            <div class="row">
				                <div class="col-md-8">
				                    <div id="datetimepicker12"></div>
				                </div>
				            </div>
				        </div>
				    </div>
				    <script type="text/javascript">
				        $(function () {
				            $('#datetimepicker12').datetimepicker({
				                inline: true,
				                sideBySide: true
				            });
				        });
				    </script>
				</div>
				</div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" id="closeButton" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" id="apptButton" class="btn btn-primary">Schedule</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script src="bower_components/underscore/underscore-min.js"></script>
	<script src="bower_components/bootstrap-calendar/js/calendar.js"></script>

	
		<div class="col-lg-10">
			<div id="calendar" style="margin-left: 10%; margin-top: 5%; background-color: #ffffff; opacity: 0.8;"></div>
		</div>
	

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