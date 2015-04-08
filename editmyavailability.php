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

	if($currentUser->get("position")=="nurse")
	{
echo <<<EOL
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
	<link href="calendar.css" rel="stylesheet" type="text/css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
EOL;
	
	if($currentUser->get("position") == "nurse")
	{
		try {
			$query=new ParseQuery("Nurse");
			$query->equalTo("email", $currentUser->get("email"));
			$nurse=$query->first();
		}
		catch (ParseException $ex) {
	
		}
	}
	
	$date = time();
	$day = date('d', $date);
	$month = date('m', $date);
	$year = date('Y', $date);
	$amount_of_months = $month+3;
	echo '<body><div class="container4"><h1>My Availability</h1></div>';
	
for($month;$month<=$amount_of_months;$month++)
{
	$first_day = mktime(0,0,0,$month,1,$year);
	$title = date('F', $first_day);
	$day_of_week = date('D', $first_day);
	
	switch($day_of_week)
	{
		case "Sun": $blank = 0; break;
		case "Mon": $blank = 1; break;
		case "Tue": $blank = 2; break;
		case "Wed": $blank = 3; break;
		case "Thu": $blank = 4; break;
		case "Fri": $blank = 5; break;
		case "Sat": $blank = 6; break;
	}
	if($amount_of_months-3==$month)
	{
		echo '<div class="container2">';
	}
	if($amount_of_months-1==$month)
	{
		echo '</div><div class="container1">';
	}
	echo '<form class="form-horizontal" action="updatenurseavailability.php" method="post" id="editProfile1" onsubmit="return validateForm()">';
	$days_in_month = cal_days_in_month(0, $month, $year);
	echo '<table border=6 width=394>';
	echo '<tr style="background-color:blue;"><th colspan=60><h2>' . $title . ' ' . $year . '</h2></th></tr>';
	echo '<tr><td width=62>S</td><td width=62>M</td><td width=62>T</td><td width=62>W</td><td width=62>T</td><td width=62>F</td><td width=62>S</td></tr>';
	
	$day_count = 1;
	echo '<tr>';
	while ($blank > 0 )
	{
		echo '<td style="background-color: gray;"></td>';
		$blank = $blank-1;
		$day_count++;
	}
	$day_num=1;
	while ($day_num <= $days_in_month )
	{
		echo '<td>' . $day_num;
$workdays = $nurse->get("WDString");
$list = explode(" ", $workdays);
				
$checked="unchecked";
foreach($list as $j)
{
	if($day_num<10)
	{
		$currentday = $month . "/0" . $day_num;
	}
	else
	{
		$currentday = $month . "/" . $day_num;

	}
	if($currentday === $j)
	{
		$checked="checked";
	}
}
echo '<input type="checkbox" name="workdays[]" style="float: right;" value="' . $currentday . '"' . $checked . '></input></br>';
echo '</td>';
		$day_num++;
		$day_count++;
		if ($day_count > 7)
		{
			echo '</tr><tr>';
			$day_count=1;
		}
	}
	while ($day_count > 1 && $day_count <=7)
	{
		echo '<td style="background-color: gray;"></td>';
		$day_count++;
	}
	
	echo '</tr></table>';
}
echo '</div><div class="container3">
			      	<button type="submit" class="btn btn-success" style="float: right; margin-right: 20px; margin-top: 10px;">Save Schedule</button>
			    </div>
		</div></form></body>';
	}
	else if($currentUser->get("position")=="physician")
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

    <link href="availability.css" rel="stylesheet">
    </head>
  <body>
	<body>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
		<h1>
			Edit Availability
			<a href="viewprofile.php">Exit without Saving</a>
		</h1>

		<div style="margin-right: 30%">
			<button class="btn btn-primary" style="float: right;" id="selNone" onclick="deselectAll()">Deselect All</button>
			<button class="btn btn-primary" style="float: right;" id="selAll" onclick="selectAll()">Select All</button>
	    </div>

		<form class="form-horizontal" id="availForm">
EOL;
	echo '<input type="radio" hidden="true" name="physEmail" id="physEmail" value="' . $currentUser->get("email") . '"><input type="radio" hidden="true" name="curIndex" id="curIndex" value="0">';
echo <<<EOL
			<label for="dateofavail" class="col-sm-2 control-label whitelabel" id="datelbl">Date:</label>
					<div class="col-sm-2">
						<div class="input-group input-append date" id="dateRangePicker">
	                		<input type="text" class="form-control" name="dateofavail" id="dateofavail" required/>
	                		<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
	            		</div>
	            		</br>
	                	<button type="submit" class="btn btn-primary" style="float: right;" id="setavail">Set Availability For Day</button>
					</div>
			<div class="col-md" style="margin: 5%">
				<table class="table table-hover table-bordered table-condensed">
	 				<tr class="active">
	 					<th class="active tableDiv">Time</th>
	 					<th class="active tableDiv">Available?</th>
	 					<th class="active tableDiv">Time</th>
	 					<th class="active tableDiv">Available?</th>
	 				</tr>
	 				<tr class="active">
	 					<td class="active"><h3 class="tableDiv">8:30-9:00</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="eightThirtyNine" value="8:30-9:00" id = "0"></div></td>
	 					<td class="active"><h3 class="tableDiv">1:00-1:30</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="oneOneThirty" value="1:00-1:30" id = "9"></div></td>
	 				</tr>
	 				<tr class="active">
	 					<td class="active"><h3 class="tableDiv">9:00-9:30</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="nineNineThirty" value="9:00-9:30" id = "1"></div></td>
	 					<td class="active"><h3 class="tableDiv">1:30-2:00</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="oneThirtyTwo" value="1:30-2:00" id="10"></div></td>
	 				</tr>
	 				<tr class="active">
	 					<td class="active"><h3 class="tableDiv">9:30-10:00</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="nineThirtyTen" value="9:30-10:00" id = "2"></div></td>
	 					<td class="active"><h3 class="tableDiv">2:00-2:30</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="twoTwoThirty" value="2:00-2:30" id="11"></div></td>
	 				</tr>
	 				<tr class="active">
	 					<td class="active"><h3 class="tableDiv">10:00-10:30</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="tenTenThirty" value="10:00-10:30" id = "3"></div></td>
	 					<td class="active"><h3 class="tableDiv">2:30-3:00</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="twoThirtyThree" value="2:30-3:00" id="12"></div></td>
	 				</tr>
	 				<tr class="active">
	 					<td class="active"><h3 class="tableDiv">10:30-11:00</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="tenThirtyEleven" value="10:30-11:00" id = "4"></div></td>
	 					<td class="active"><h3 class="tableDiv">3:00-3:30</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="threeThreeThirty" value="3:00-3:30" id="13"></div></td>
	 				</tr>
	 				<tr class="active">
	 					<td class="active"><h3 class="tableDiv">11:00-11:30</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="elevenElevenThirty" value="11:00-11:30" id = "5"></div></td>
	 					<td class="active"><h3 class="tableDiv">3:30-4:00</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="threeThirtyFour" value="3:30-4:00" id="14"></div></td>
	 				</tr>
	 				<tr class="active">
	 					<td class="active"><h3 class="tableDiv">11:30-12:00</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="elevenThirtyNoon" value="11:30-12:00" id = "6"></div></td>
	 					<td class="active"><h3 class="tableDiv">4:00-4:30</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="fourFourThirty" value="4:00-4:30" id="15"></div></td>
	 				</tr>
	 				<tr class="active">
	 					<td class="active"><h3 class="tableDiv">12:00-12:30</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="noonNoonThirty" value="12:00-12:30" id = "7"></div></td>
	 					<td class="active"><h3 class="tableDiv">4:30-5:00</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="fourThirtyFive" value="4:30-5:00" id="16"></div></td>
	 				</tr>
	 				<tr class="active">
	 					<td class="active"><h3 class="tableDiv">12:30-1:00</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="noonThirtyOne" value="12:30-1:00" id = "8"></div></td>
	 					<td class="active"><h3 class="tableDiv">5:00-5:30</h3></td>
	 					<td class="active"><div class="checkboxDiv"><input type="checkbox" class="form-control" name="fiveFiveThirty" value="5:00-5:30" id="17"></div></td>
	 				</tr>
				</table>
			</div>
		</form>
		

		<script>

			$('#availForm').submit(function () {
 				updateTimes();
 				document.getElementById("setavail").disabled = true;
 				document.getElementById("setavail").innerHTML = "Updated!";
 				return false;
			});

			function updateTimes()
			{
				Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

				for(var i = 0; i < 18; i++)
				{
					(function(i){
						var appointment = Parse.Object.extend("appointments");
						var query = new Parse.Query(appointment);

						query.equalTo("physicianEmail", document.getElementById("physEmail").value);
						query.equalTo("Date", document.getElementById("dateofavail").value);
						query.equalTo("Time", document.getElementById(i).value);

						query.find({
						  success: function(results) {
						    // Do something with the returned Parse.Object values
						    var index = i;

						    if(!results[0])
						    {
							    var appointment = Parse.Object.extend("appointments");
								var appoint = new appointment();
								
							   	appoint.set("physicianEmail", document.getElementById("physEmail").value);
								appoint.set("Date", document.getElementById("dateofavail").value);
								appoint.set("Time", document.getElementById(index).value);
								appoint.set("timeID", document.getElementById(index).id);

								if(document.getElementById(index).checked)
								{
									appoint.set("available", "true");
								}
								else
								{
									appoint.set("available", "false");
								}

								appoint.save(null, {
								  success: function(appoint) {
								  },
								  error: function(appoint, error) {
								  }
								});
							}
							else
							{
								if(document.getElementById(index).checked == true)
								{
									if(!document.getElementById(index).disabled)
									{
										results[0].set("available", "true");
									}
								}
								else
								{
									if(!document.getElementById(index).disabled)
									{
										results[0].set("available", "false");
									}
								}
								results[0].save();
							}
						  },
						  error: function(error) {
						    alert("Error: " + error.code + " " + error.message);
						  }
						});
					})(i);
				}	


			}
			function editTimes()
			{
				document.getElementById("setavail").disabled = false;
 				document.getElementById("setavail").innerHTML = "Set Availability For Day";
 				Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
 				var appointment = Parse.Object.extend("appointments");
				var query = new Parse.Query(appointment);

				query.equalTo("physicianEmail", document.getElementById("physEmail").value);
				query.equalTo("Date", document.getElementById("dateofavail").value);

				for(var i = 0; i < 18; i++)
				{
					document.getElementById(i).checked = false;
				}

				query.find({
					  success: function(results) {
					  	for(var i = 0; i < results.length; i++)
					  	{
					  		if(results[i].get("available") == "true")
					  		{
					  			document.getElementById(results[i].get("timeID")).checked = true;
					  			document.getElementById(results[i].get("timeID")).disabled = false;
					  		}
					  		else if(results[i].get("available") == "false")
					  		{
					  			document.getElementById(results[i].get("timeID")).checked = false;
					  			document.getElementById(results[i].get("timeID")).disabled = false;
					  		}
					  		else
					  		{
					  			document.getElementById(results[i].get("timeID")).disabled = true;
					  		}
					  	}
					  },
					  error: function(error) {
					    alert("MADE IT!");
					  }
				});
			}

			function deselectAll()
			{
				for(var i = 0; i < 18; i++)
				{
					document.getElementById(i).checked = false;
				}
			}

			function selectAll()
			{
				for(var i = 0; i < 18; i++)
				{
					document.getElementById(i).checked = true;
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
			            editTimes();
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
			});
		</script>
	</body>
  </body>
</html>
EOL;
	}
	else
	{
		header("Location: index.php");
	}
?>