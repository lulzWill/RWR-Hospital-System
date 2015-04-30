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
  		Edit SignupKeys
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
			Edit Specialties and Signup Keys
		</h1>
		<div class="container" style="float: right; width: 50%;">
		<table class="table table-hover table-bordered table-condensed table-striped" style="margin-left: 10%; width: 80% !important; margin-bottom: 1%;">
	 		<tr class="active">
	 			<th class="active tableDiv">Position</th>
	 			<th class="active tableDiv">Signup Key</th>
	 		</tr>
EOL;
	$query = new ParseQuery("signupKeys");
	$query->ascending("position");
	$results = $query->find();
	for ($i = 0; $i < count($results); $i++) 
	{ 
		echo	'<td class="active tableDiv">' . $results[$i]->get("position") . '</th>';
	 	echo	'<td class="active tableDiv"><input type="text" class="form-control" style="width: 100%;"id="key';
	 	echo     $i;
	 	echo     '" name="key';
	 	echo     $i;
	 	echo     '" value="';
	 	echo     $results[$i]->get("key");
		echo     '" required></th>';
		echo    '</tr>';
	}
echo <<<EOL
		</table>
EOL;
		echo    '<input type="button" class="btn btn-primary pull-right" id="btnSub" onclick="UpdateKeys()" value="Updates Keys" style="margin-right: 10%; margin-top: 0%;"/>';
echo <<<EOL
		</div>
		<div class="container" style="float: left; width: 50%;">
		<table class="table table-hover table-bordered table-condensed table-striped" style="margin-left: 10%; width: 80% !important; margin-bottom: 1%;">
	 		<tr class="active">
	 			<th class="active tableDiv">Specialty</th>
				<th class="active tableDiv">Base Salary</th>
	 			<th class="active tableDiv">Action</th>
				<th class="active tableDiv">Edit</th>
	 		</tr>
EOL;
	$query = new ParseQuery("Specialties");
	$query->ascending("name");
	$results = $query->find();
	for ($i = 0; $i < count($results); $i++) 
	{ 
		echo '<tr class="active" data-specialty="'. $results[$i]->get("name") .'" >';
		echo 	'<input type="hidden" class="form-control" name="removespec';
		echo 	$i;
		echo 	'" id="removespec';
		echo    $i;
		echo    '" value="';
		echo 	$results[$i]->getObjectId();
		echo 	'">'; 
		echo	'<td class="active tableDiv">' . $results[$i]->get("name") . '</th>';
		echo    '<td class="active tableDiv">$';
		echo    $ecurrentsalary = number_format($results[$i]->get("salary"));
		echo    '</th>';
		echo	'<td class="active tableDiv"><input type="button" class="btn btn-danger pull-right" name="button"id="';
		echo    $i;
		echo    '" onclick="RemoveSpecialty(this.id)" value="Remove" style="margin-right: 10%; margin-top: 0%;"/></th>';
		echo	'<td class="active tableDiv"><input type="button" class="btn btn-warning pull-right" name="button"id="';
		echo    $i;
		echo    '" onclick="" data-toggle="modal" data-target="#basicModal" data-specialty="' . $results[$i]->get("name") . '" value="Edit" style="margin-right: 10%; margin-top: 0%;"/></th></tr>';
		echo    '</th>';
		echo	'</tr>';
	}

	echo	'<td class="active tableDiv"><input type="text" class="form-control" style="width: 100%;"id="newspec" name="newspec" placeholder="Specialty Title" required></th>';
	echo	'<td class="active tableDiv"><input type="number" class="form-control" style="width: 100%;"id="newsal" name="newsal" placeholder="Number Value" required></th>';
	echo	'<td class="active tableDiv"><input type="button" class="btn btn-primary pull-right" id="btnSub2" onclick="AddSpecialty()" value="Add New" style="margin-right: 10%; margin-top: 0%;"/></th>';



echo <<<EOL
		</table>
EOL;
echo <<<EOL
		</div>
		
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
					<label id="editLabel" for="editLabel" class="col-sm-12 control-label blacklabel" style="text-align: left;"></label>
  					<input type="text" class="form-control" id="editBox">
				</div>
				</div>
				
	

				
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" id="closeBtn" data-dismiss="modal">Close</button>
		        <button type="button" onClick="UpdateSpecialty()" class="btn btn-info" id="updateBtn" data-dismiss="modal">Change Salary</button>
		        <!--
		        <input type="button" id="payButton" class="btn btn-success" onclick="Update()" value="Pay Now"/>
		        -->
		      </div>
			  </form>

		    </div>
		  </div>
		</div>
	</body>
	<script type="text/javascript">

		function UpdateKeys() {

			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
			if(!document.getElementById("key0").value || !document.getElementById("key1").value || !document.getElementById("key2").value)
			{
				if(!document.getElementById("key0").value)
				{
					alert("ERROR: Admin Signup Key is blank!");
				}
				else if(!document.getElementById("key1").value)
				{
					alert("ERROR: Nurse Signup Key is blank!");
				}
				else
				{
					alert("ERROR: Physician Signup Key is blank!");
				}
			}
			else
			{

				var keys = Parse.Object.extend("signupKeys");
				var query = new Parse.Query(keys);
				query.equalTo("position", "admin");
				query.first({
						success: function(object) {
							object.set("key", document.getElementById("key0").value);
							object.save();
						  },
						  error: function(error) {
							alert("Error: " + error.code + " " + error.message);
						  }
				});

				var keys = Parse.Object.extend("signupKeys");
				var query = new Parse.Query(keys);
				query.equalTo("position", "nurse");
				query.first({
						success: function(object) {
							object.set("key", document.getElementById("key1").value);
							object.save();
						  },
						  error: function(error) {
							alert("Error: " + error.code + " " + error.message);
						  }
				});

				var keys = Parse.Object.extend("signupKeys");
				var query = new Parse.Query(keys);
				query.equalTo("position", "physician");
				query.first({
						success: function(object) {
							object.set("key", document.getElementById("key2").value);
							object.save();
						  },
						  error: function(error) {
							alert("Error: " + error.code + " " + error.message);
						  }
				});
				document.getElementById("btnSub").disabled = true;
				document.getElementById("btnSub").value = "Please Wait...";
				setTimeout(function(){location.reload(); },1000); 
			}
		}



		function AddSpecialty() {

			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
			var Specialty = Parse.Object.extend("Specialties");
			var spec = new Specialty();
			if(!document.getElementById("newspec").value || !document.getElementById("newsal").value)
			{
				if(!document.getElementById("newspec").value)
				{
					alert("ERROR: Specialty Title was not specified");
				}
				else if(!document.getElementById("newsal").value)
				{
					alert("ERROR: Salary was not specified or not a number");
				}
			}
			else
			{
				
				spec.set("name", document.getElementById("newspec").value);
				spec.set("salary", +document.getElementById("newsal").value);

				spec.save(null, {
				  success: function(gameScore) {
					// Execute any logic that should take place after the object is saved.
					document.getElementById("btnSub2").disabled = true;
					document.getElementById("btnSub2").value = "Please Wait...";
					setTimeout(function(){location.reload(); },1000); 
				  },
				  error: function(gameScore, error) {
					// Execute any logic that should take place if the save fails.
				  }
				});
			}
		}

		function RemoveSpecialty(x) {
			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
			var g = "removespec" + x;
			var Specialty = Parse.Object.extend("Specialties");
			var query = new Parse.Query(Specialty);
			query.equalTo("objectId", document.getElementById(g).value);
			query.first({
            		success: function(object) {
					  	object.destroy({
						  success: function(myObject) {
						    // The object was deleted from the Parse Cloud.
						    document.getElementById(x).disabled = true;
							document.getElementById(x).value = "Please Wait...";
							location.reload(); 
						  },
						  error: function(myObject, error) {
						    // The delete failed.
						    // error is a Parse.Error with an error code and message.
						  }
						});
					  },
					  error: function(error) {
					    alert("Error: " + error.code + " " + error.message);
					  }
			});
		}
		
		
		function UpdateSpecialty(x) {
			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
			var g = "removespec" + x;
			var Specialty = Parse.Object.extend("Specialties");
			var query = new Parse.Query(Specialty);
			query.equalTo("objectId", document.getElementById(g).value);
			query.first({
            		success: function(object) {
						object.set("salary", document.getElementById().value);
					  	object.save(null, {
						  success: function(myObject) {
						    // The object was deleted from the Parse Cloud.
						    document.getElementById(x).disabled = true;
							document.getElementById(x).value = "Please Wait...";
							location.reload(); 
						  },
						  error: function(myObject, error) {
						    // The delete failed.
						    // error is a Parse.Error with an error code and message.
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
			        var specialty = $(event.target).closest('tr').data('specialty'); //get the id from tr
			        console.log(specialty);
			        $(this).find('editLabel').html($('<b> Set new salary for: ' + specialty  + '</b>'));
			        //$(this).find('#currentObjectId2').val(getIdFromRow);

			        
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