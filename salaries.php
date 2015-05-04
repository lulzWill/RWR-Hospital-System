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
	$sessionToken = ParseUser::getCurrentUser()->getSessionToken();

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
  		Employee Payouts
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
<input hidden="true" id="currSessionToken" value='
EOL;
echo $sessionToken;
echo <<<EOL
'/>
    </head>
  <body>
  	<div class="container">
	  <div class="jumbotron">
	    <h1 class="text-center">Employee Salaries & Payments</h1>
	</div>
	<body>
		<h1>
			Physicians
		</h1>
		<table class="table table-hover table-bordered table-condensed table-striped" style="margin-left: 10%; width: 80% !important;">
	 		<tr class="active">
	 			<th class="active tableDiv">Name</th>
				 <!--
	 			<th class="active tableDiv">Email</th>
				 -->
				<th class="active tableDiv">Specialty</th>
				<th class="active tableDiv">Experience</th>
				<th class="active tableDiv">Salary</th>
				<th class="active tableDiv">Current Appointment Bonuses</th>
				<th class="active tableDiv">Last Paid</th>
				<th class="active tableDiv">Release Payout</th>
	 		</tr>
EOL;
	$query = ParseUser::query();
	$query->equalTo("emailVerified", true);
	$query->equalTo("position", "physician");
	//$query->descending("position");
	$results = $query->find();

	for ($i = 0; $i < count($results); $i++) 
	{ 
  		$object = $results[$i];
		  
		$docQuery = new ParseQuery("Physician");
  		$docQuery->equalTo("email", $object->get("email"));
  		$docResults = $docQuery->find();
		  
		$salaryQuery = new ParseQuery("Specialties");
		$firstSpecialty = $docResults[0]->get("specialties");

		$localMax = 0;
		$maxSpec;
		for($j = 0; $j < count($firstSpecialty); $j++)
		{
			$localSpec = $salaryQuery->equalTo("name", $firstSpecialty[$j]);
			$localSpec = $localSpec->find();

			if($localSpec[0]->get("salary") > $localMax)
			{
				$localMax = $localSpec[0]->get("salary");
				$maxSpec = $localSpec[0]->get("name");
			}
		}
		
		$salaryQuery->equalTo("name", $maxSpec);
		$salaryResults = $salaryQuery->find();
		
		$adjustedSalary = intval($salaryResults[0]->get("salary")) + intval($docResults[0]->get("years"))*(.01)*intval($salaryResults[0]->get("salary"));
		  
  		echo '<tr class="active"  data-target="#basicModal" data-id =" '.$i.' " data-object-id="'.$object->getObjectId().' " data-name ="'.$object->get("firstname").' '.$object->get("lastname").'" data-email ="'.$object->get("email").'"
  		data-position="'. $object->get("position") .'" ">';
	 	echo	'<td class="active tableDiv">' . $object->get("lastname") . ', ' . $object->get("firstname") .'</th>';
	 	//echo	'<td class="active tableDiv">' . $object->get("email") . '</th>';
		echo	'<td class="active tableDiv">' .$maxSpec. '</th>';
		echo	'<td class="active tableDiv">' .$docResults[0]->get("years"). ' years</th>';
		echo	'<td class="active tableDiv">$ ' . number_format($adjustedSalary) . '</th>';
		echo	'<td class="active tableDiv">$ ' .number_format($docResults[0]->get("apptBonuses")). '</th>';
		echo	'<td class="active tableDiv">' .$docResults[0]->get("lastPaid"). '</th>';
		echo    '<td class="active tableDiv">';
		echo	'<a href="#" id="doctor';
		echo $i;
		echo    '" class="btn btn-success" data-email="'.$object->get("email").'" data-salary="'.$adjustedSalary.'" data-bonuses="'.$docResults[0]->get("apptBonuses").'" onclick="releasePayment(this.id)">Pay</a>';
		if($object->get("position") != "admin")
		{
			//echo '<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#'. $object->get("position") .'Modal" data-email="'.$object->get("email").'">Edit User</a>';
		}
		echo    '</tr>';
	}
echo <<<EOL
		</table>
		
		
		<h1>
			Nurses
		</h1>
		<table class="table table-hover table-bordered table-condensed table-striped" style="margin-left: 10%; width: 80% !important;">
	 		<tr class="active">
	 			<th class="active tableDiv">Name</th>
				 <!--
	 			<th class="active tableDiv">Email</th>
				 -->
				<th class="active tableDiv">Specialty</th>
				<th class="active tableDiv">Experience</th>
				<th class="active tableDiv">Salary</th>
				<th class="active tableDiv">Current Appointment Bonuses</th>
				<th class="active tableDiv">Last Paid</th>
				<th class="active tableDiv">Release Payout</th>
	 		</tr>
EOL;
	$query2 = ParseUser::query();
	$query2->equalTo("emailVerified", true);
	$query2->equalTo("position", "nurse");
	//$query->descending("position");
	$results2 = $query2->find();

	for ($i = 0; $i < count($results2); $i++) 
	{ 
  		$object2 = $results2[$i];
		  
		$docQuery2 = new ParseQuery("Nurse");
  		$docQuery2->equalTo("email", $object2->get("email"));
  		$docResults2 = $docQuery2->find();
		
		/* 
		$salaryQuery2 = new ParseQuery("Specialties");
		$firstSpecialty = $docResults[0]->get("specialties");
		$salaryQuery->equalTo("name", $firstSpecialty[0]);
		$salaryResults = $salaryQuery->find();
		*/
		
		$adjustedSalary2 = intval($salaryResults[0]->get("salary"))*(.3) + intval($docResults2[0]->get("years"))*(.005)*intval($salaryResults[0]->get("salary"));
		//$adjustedSalary2 = 60000 * intval($docResults2[0]->get("years"));
		  
  		echo '<tr class="active"  data-target="#basicModal" data-id =" '.$i.' " data-object-id="'.$object2->getObjectId().' " data-name ="'.$object2->get("firstname").' '.$object2->get("lastname").'" data-email ="'.$object2->get("email").'"
  		data-position="'. $object2->get("position") .'" ">';
	 	echo	'<td class="active tableDiv">' . $object2->get("lastname") . ', ' . $object2->get("firstname") .'</th>';
	 	//echo	'<td class="active tableDiv">' . $object->get("email") . '</th>';
		echo	'<td class="active tableDiv">Nursing</th>';
		echo	'<td class="active tableDiv">' .$docResults2[0]->get("years"). ' years</th>';
		echo	'<td class="active tableDiv">$ ' . number_format($adjustedSalary2) . '</th>';
		echo	'<td class="active tableDiv">$ ' .number_format($docResults2[0]->get("apptBonuses")). '</th>';
		echo	'<td class="active tableDiv">' .$docResults2[0]->get("lastPaid"). '</th>';
		echo    '<td class="active tableDiv">';
		echo	'<a href="#" id="payNurseButton'.$i.'" class="btn btn-success" data-email="'.$object2->get("email").'" data-salary="'.$adjustedSalary2.'" data-bonuses="'.$docResults2[0]->get("apptBonuses").'" onclick="releaseNursePayment(this.id)">Pay</a>';
		if($object->get("position") != "admin")
		{
			//echo '<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#'. $object->get("position") .'Modal" data-email="'.$object->get("email").'">Edit User</a>';
		}
		echo    '</tr>';
	}
echo <<<EOL
		</table>
		
		
<!--	
		<h1>
			Administrators
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
	$query->equalTo("position", "admin");
	//$query->descending("position");
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
		if($object->get("position") != "admin")
		{
			echo '<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#'. $object->get("position") .'Modal" data-email="'.$object->get("email").'">Edit User</a>';
		}
		echo    '</tr>';
	}
echo <<<EOL
		</table>
-->		
		<div id="hidden_form_container" style="display:none;"></div>
	</body>




	<script type="text/javascript">
	
		function releasePayment(btnId) {
			
			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
			
			
			var monthlySalary = document.getElementById(btnId).getAttribute("data-salary");
			var monthlyBonus = document.getElementById(btnId).getAttribute("data-bonuses");
			var monthPay = parseInt(monthlySalary,10) + parseInt(monthlyBonus,10);
			
			 	var doc = Parse.Object.extend("Physician");
                var docQuery = new Parse.Query(doc);
                docQuery.equalTo("email", document.getElementById(btnId).getAttribute("data-email"));
                docQuery.first({
                      success: function(results) {
		                        results.set("apptBonuses", 0);
								var today = todaysDate();
								var lastPaid = results.get("lastPaid");
								results.set("lastPaid", today);
		                        results.save(null, {
              			  			success: function(object) {
              			  					document.getElementById(btnId).disabled = true;
              			  					document.getElementById(btnId).innerHTML = "Please Wait...";
              			  					

											var theForm, newInput1, newInput2;
											// Start by creating a <form>
											theForm = document.createElement('form');
											theForm.action = 'notifySalaryPaid.php';
											theForm.method = 'post';
											// Next create the <input>s in the form and give them names and values
											newInput1 = document.createElement('input');
											newInput1.type = 'hidden';
											newInput1.name = 'doctorEmail';
											newInput1.value = results.get("email");
											newInput6 = document.createElement('input');
											newInput6.type = 'hidden';
											newInput6.name = 'lastPaid';
											newInput6.value = lastPaid;
											newInput7 = document.createElement('input');
											newInput7.type = 'hidden';
											newInput7.name = 'today';
											newInput7.value = today;
											newInput8 = document.createElement('input');
											newInput8.type = 'hidden';
											newInput8.name = 'payment';
											newInput8.value = monthPay;
											// Now put everything together...
											theForm.appendChild(newInput1);
											theForm.appendChild(newInput6);
											theForm.appendChild(newInput7);
											theForm.appendChild(newInput8);
											// ...and it to the DOM...
											document.getElementById('hidden_form_container').appendChild(theForm);
											// ...and submit it
											theForm.submit();
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
		
		
		function releaseNursePayment(nurseId) {
			
			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
			
			var monthlySalary = document.getElementById(nurseId).getAttribute("data-salary");
			var monthlyBonus = document.getElementById(nurseId).getAttribute("data-bonuses");
			var monthPay = parseInt(monthlySalary,10) + parseInt(monthlyBonus,10);
			
			 	var nurse = Parse.Object.extend("Nurse");
                var nurseQuery = new Parse.Query(nurse);
                nurseQuery.equalTo("email", document.getElementById(nurseId).getAttribute("data-email"));
                nurseQuery.first({
                      success: function(results) {
		                        results.set("apptBonuses", 0);
								var today = todaysDate();
								var lastPaid = results.get("lastPaid");
								results.set("lastPaid", today);
		                        results.save(null, {
              			  			success: function(object) {
											document.getElementById(nurseId).disabled = true;
              			  					document.getElementById(nurseId).innerHTML = "Please Wait...";
              			  					

											var theForm, newInput1, newInput2;
											// Start by creating a <form>
											theForm = document.createElement('form');
											theForm.action = 'notifySalaryPaid.php';
											theForm.method = 'post';
											// Next create the <input>s in the form and give them names and values
											newInput1 = document.createElement('input');
											newInput1.type = 'hidden';
											newInput1.name = 'doctorEmail';
											newInput1.value = results.get("email");
											newInput6 = document.createElement('input');
											newInput6.type = 'hidden';
											newInput6.name = 'lastPaid';
											newInput6.value = lastPaid;
											newInput7 = document.createElement('input');
											newInput7.type = 'hidden';
											newInput7.name = 'today';
											newInput7.value = today;
											newInput8 = document.createElement('input');
											newInput8.type = 'hidden';
											newInput8.name = 'payment';
											newInput8.value = monthPay;
											// Now put everything together...
											theForm.appendChild(newInput1);
											theForm.appendChild(newInput6);
											theForm.appendChild(newInput7);
											theForm.appendChild(newInput8);
											// ...and it to the DOM...
											document.getElementById('hidden_form_container').appendChild(theForm);
											// ...and submit it
											theForm.submit();
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
		
		function todaysDate() {
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
			return today;
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
					  		document.getElementById("prof_pic_img").src = object.get("prof_pic").url();
					  		document.getElementById("email").value = object.get("email");
					  		document.getElementById("degree").value = object.get("degree");
					  		document.getElementById("school").value = object.get("school");
					  		document.getElementById("years").value = object.get("years");
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

			    }).on('show.bs.modal', function(event) {
			        Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

			    	var usr = Parse.Object.extend("Patient");
					var query = new Parse.Query(usr);
					var curEmail = $(event.relatedTarget).data('email');

					query.equalTo("email", curEmail);
					query.first({
					  success: function(object) {
					  		document.getElementById("prof_pic_img_pat").src = object.get("prof_pic").url();
					  		document.getElementById("email_pat").value = object.get("email");
					  		document.getElementById("address_pat").value = object.get("address");
					  		document.getElementById("citystate_pat").value = object.get("citystate");
					  		document.getElementById("zipcode_pat").value = object.get("zipcode");
					  		document.getElementById("cellphone").value = object.get("cellphone");
					  		document.getElementById("homephone").value = object.get("homephone");
					  		document.getElementById("emerg_num").value = object.get("emerg_num");
					  		document.getElementById("emerg_name").value = object.get("emerg_name");
					  		document.getElementById("emerg_rel").value = object.get("emerg_rel");
					  		document.getElementById("emerg_num2").value = object.get("emerg_num2");
					  		document.getElementById("emerg_name2").value = object.get("emerg_name2");
					  		document.getElementById("emerg_rel2").value = object.get("emerg_rel2");
					  		document.getElementById("insurance").value = object.get("insurance");
					  		document.getElementById("pre_conditions").value = object.get("pre_conditions");
					  		document.getElementById("allergies").value = object.get("allergies");
					  		document.getElementById("medications").value = object.get("medications");

					  		var usr = Parse.Object.extend("User");
							var query = new Parse.Query(usr);
							query.equalTo("email", curEmail);
							query.first({
								success: function(object) {
									document.getElementById("firstName_pat").value = object.get("firstname");
									document.getElementById("lastName_pat").value = object.get("lastname");
									document.getElementById("bday_pat").value = object.get("dateOfBirth");
									document.getElementById("role_pat").value = object.get("position");
									document.getElementById("sex_pat").value = object.get("sex");
									document.getElementById("patModalLabel").innerHTML = "Edit Patient - " + object.get("firstname") + " " + object.get("lastname");
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
			$('#nurseModal').modal({
				show:false

			    }).on('show.bs.modal', function(event) {
			        Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

			    	var usr = Parse.Object.extend("Nurse");
					var query = new Parse.Query(usr);
					var curEmail = $(event.relatedTarget).data('email');

					query.equalTo("email", curEmail);
					query.first({
					  success: function(object) {
					  		document.getElementById("prof_pic_img_nur").src = object.get("prof_pic").url();
					  		document.getElementById("email_nur").value = object.get("email");
					  		document.getElementById("degree_nur").value = object.get("degree");
					  		document.getElementById("school_nur").value = object.get("school");
					  		document.getElementById("years_nur").value = object.get("years");
					  		document.getElementById("address_nur").value = object.get("address");
					  		document.getElementById("citystate_nur").value = object.get("citystate");
					  		document.getElementById("zipcode_nur").value = object.get("zipcode");
					  		document.getElementById("phone_nur").value = object.get("phone");

					  		var usr = Parse.Object.extend("User");
							var query = new Parse.Query(usr);
							query.equalTo("email", curEmail);
							query.first({
								success: function(object) {
									document.getElementById("firstName_nur").value = object.get("firstname");
									document.getElementById("lastName_nur").value = object.get("lastname");
									document.getElementById("bday_nur").value = object.get("dateOfBirth");
									document.getElementById("role_nur").value = object.get("position");
									document.getElementById("sex_nur").value = object.get("sex");
									document.getElementById("nurModalLabel").innerHTML = "Edit Nurse - " + object.get("firstname") + " " + object.get("lastname");
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
	</script>


</html>
EOL;
	}
	else 
	{
		header("Location: index.php");
	}
?>