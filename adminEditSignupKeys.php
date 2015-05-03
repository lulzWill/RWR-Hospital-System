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
		echo    '<input type="hidden" name="myid" id="myid" value"' . $results[$i]->getObjectId() . '">';
		echo    '<tr class="active" data-specialty="'. $results[$i]->get("name") .'" >';
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
		echo  	'<td class="active tableDiv"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal" data-objectid="' . $results[$i]->getObjectId() . '" data-specialty="'.$results[$i]->get("name").'" data-salary="' . $results[$i]->get("salary") . '"';
echo <<<EOL
">
		Edit
	</button>
	<div class="modal fade myModal
EOL;
echo $i;
echo <<<EOL
" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel
EOL;
echo $i;
echo <<<EOL
" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel
EOL;
echo $i;
echo <<<EOL
">Appointment Info</h4>
		  </div>
		  <div class="modal-body">
		     <form>
			    <input type="hidden" class="object" id="object" name="object">
				<input type="hidden" class="name" id="name" name="name">
			    <label for="updatesal" class="control-label" style="float: left; margin-right: 0px; padding-top 5px;">Salary:  $</label>
				<input type="number" class="form-control" id="updatesal" name="updatesal">
			 </form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" id="closeBtn" data-dismiss="modal">Close</button>
			<input type="button" class="btn btn-success" id="submitBtn" onclick="UpdateSalary()" value="Change Salary"/>
		  </div>
		</div>
	  </div>
	</div>
 </th>
				
EOL;
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
	</body>
	<script type="text/javascript">
	
	$('#myModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var spec = button.data('specialty')
		var salary = button.data('salary')
		var objectid = button.data('objectid')
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		modal.find('.modal-title').text(spec)
		modal.find('.form-control').val(salary)
		modal.find('.object').val(objectid)
		modal.find('.name').val(spec)
})

		
		function UpdateSalary() {
			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
			if(!document.getElementById("updatesal").value)
			{
				alert("ERROR: Salary was not specified or not a number!");
			}
			else
			{
				var getID = document.getElementById("object").value;
				var getName = document.getElementById("name").value;
				var getSal = document.getElementById("updatesal").value;
				var sal = Parse.Object.extend("Specialties");
				var query = new Parse.Query(sal);
				query.equalTo("objectId", document.getElementById("object").value);
				query.first({
					success: function(object){
						object.set("salary", +getSal);
						object.save();
					},
					error: function(error) {
						alert("Error: " + error.code + " " + error.message);
					}
				});
				document.getElementById("submitBtn").disabled = true;
				document.getElementById("submitBtn").value = "Saving Change";
				setTimeout(function(){location.reload(); },1000); 
			}
		}
	
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
	</script>
</html>
EOL;
	}
	else 
	{
		header("Location: index.php");
	}
?>