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
	 			<th class="active tableDiv">Action</th>
	 			<th class="active tableDiv">Specialty</th>
	 			<th class="active tableDiv">Action</th>
	 		</tr>
EOL;
	$query = new ParseQuery("Specialties");
	$query->ascending("name");
	$results = $query->find();
	for ($i = 0; $i < count($results); $i++) 
	{ 
		echo 	'<input type="hidden" class="form-control" name="removespec';
		echo 	$i;
		echo 	'" id="removespec';
		echo    $i;
		echo    '" value="';
		echo 	$results[$i]->getObjectId();
		echo 	'">'; 
		echo	'<td class="active tableDiv">' . $results[$i]->get("name") . '</th>';
		echo	'<td class="active tableDiv"><input type="button" class="btn btn-danger pull-right" name="button"id="';
		echo    $i;
		echo    '" onclick="RemoveSpecialty(this.id)" value="Remove" style="margin-right: 10%; margin-top: 0%;"/></th>';
		if(($i+1)%2==0)
		{
			echo    '</tr>';
		}
	}

	echo	'<td class="active tableDiv"><input type="text" class="form-control" style="width: 100%;"id="newspec" name="newspec" required></th>';
	echo	'<td class="active tableDiv"><input type="button" class="btn btn-primary pull-right" id="btnSub2" onclick="AddSpecialty()" value="Add New" style="margin-right: 10%; margin-top: 0%;"/></th>';



echo <<<EOL
		</table>
EOL;
echo <<<EOL
		</div>
	</body>




	<script type="text/javascript">

		function UpdateKeys() {

			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

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



		function AddSpecialty() {

			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
			var Specialty = Parse.Object.extend("Specialties");
			var spec = new Specialty();
			spec.set("name", document.getElementById("newspec").value);

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