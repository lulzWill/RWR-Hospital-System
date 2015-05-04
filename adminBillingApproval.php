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
  		Approve/Deny Billing
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
			Approve/Deny Billing Request
		</h1>
		<div class="container">
		<table class="table table-hover table-bordered table-condensed table-striped" style="margin-left: 10%; width: 80% !important; margin-bottom: 1%;">
	 		<tr class="active">
	 			<th class="active tableDiv">Date</th>
	 			<th class="active tableDiv">Time</th>
				<th class="active tableDiv">Specialty</th>
				<th class="active tableDiv">Doctor</th>
				<th class="active tableDiv">Patient</th>
				<th class="active tableDiv">Proposed Price</th>
				<th class="active tableDive">View Notes</th>
				<th class="active tableDiv">Approve/Deny</th>
	 		</tr>
EOL;
	$query = new ParseQuery("appointments");
	$query->equalTo("available", "complete");
	$results = $query->find();
	for ($i = 0; $i < count($results); $i++) 
	{ 
		$object=$results[$i];
		$innerQuery = new ParseQuery("Patient");
  		$innerQuery->equalTo("email", $object->get("patientEmail"));
  		$innerResults = $innerQuery->find();
		
		$innerQuery2 = new ParseQuery("Physician");
  		$innerQuery2->equalTo("email", $object->get("physicianEmail"));
  		$innerResults2 = $innerQuery2->find();
		echo 	'<input type="hidden" class="form-control" name="object';
		echo 	$i;
		echo 	'" id="object';
		echo    $i;
		echo    '" value="';
		echo 	$results[$i]->getObjectId();
		echo 	'">'; 
		echo	'<td class="active tableDiv">' . $results[$i]->get("Date") . '</th>';
		echo	'<td class="active tableDiv">' . $results[$i]->get("Time") . '</th>';
		echo	'<td class="active tableDiv">' . $results[$i]->get("specialty") . '</th>';
		echo	'<td class="active tableDiv">' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name") . '</th>';
		echo    '<td class="active tableDiv">';
echo <<<EOL
<form method="POST" action="patientsearch.php" id="patientsearch">
              <input type="hidden" class="form-control" name="patientemail" id="patientemail" value="
EOL;
echo $object->get("patientEmail");
echo <<<EOL
"> 
EOL;
        echo '<button type="submit" class="btn btn-info">' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name") . '</button>';
echo <<<EOL
            </form>
		</th>
EOL;
		echo	'<td class="active tableDiv">$' . number_format($results[$i]->get("price")) . '</th>';
		echo    '<td class="active tableDiv"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#notesModal" data-notes="'.$results[$i]->get("notes") .'">View Notes</button></th>';
		echo	'<td class="active tableDiv"><input type="button" class="btn btn-success pull-left" name="button"id="';
		echo    $i;
		echo    '1" onclick="Approve(this.id)" value="Approve" style="margin-right: 1%; margin-top: 0%;"/>';
		echo	'<input type="button" class="btn btn-danger pull-left" name="button"id="';
		echo    $i;
		echo    '2" onclick="Deny(this.id)" value="Deny" style="margin-right: 0%; margin-top: 0%;"/></th></tr>';
	}
echo <<<EOL
		</table>
EOL;
echo <<<EOL
		<div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Appointment Notes</h4>
		      </div>
		      <div class="modal-body">
				<textarea readonly="true" class="form-control1" rows="10" style="width:100%" id="notes" name="notes">
				</textarea>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
		</div>
		<div id="hidden_form_container" style="display:none;"></div>
	</body>
	<script type="text/javascript">
		function Approve(x) {
			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
			y = Math.floor(x/10);
			var g = "object" + y;
			var appointments = Parse.Object.extend("appointments");
			var query = new Parse.Query(appointments);
			query.equalTo("objectId", document.getElementById(g).value);
			query.first({
						success: function(object) {
							object.set("available", "approved");
							object.save();
							document.getElementById(x).disabled = true;
							document.getElementById(x).value = "Approving...";

							// update new appt to taken
							var theForm, newInput1, newInput2;
							// Start by creating a <form>
							theForm = document.createElement('form');
							theForm.action = 'notifyComplete.php';
							theForm.method = 'post';
							// Next create the <input>s in the form and give them names and values
							newInput1 = document.createElement('input');
							newInput1.type = 'hidden';
							newInput1.name = 'patientEmail';
							newInput1.value = object.get("patientEmail");
							newInput2 = document.createElement('input');
							newInput2.type = 'hidden';
							newInput2.name = 'nurseEmail';
							newInput2.value = object.get("nurseEmail");
							newInput3 = document.createElement('input');
							newInput3.type = 'hidden';
							newInput3.name = 'physicianEmail';
							newInput3.value = object.get("physicianEmail");
							newInput4 = document.createElement('input');
							newInput4.type = 'hidden';
							newInput4.name = 'aptNotes';
							newInput4.value = object.get("notes");
							newInput5 = document.createElement('input');
							newInput5.type = 'hidden';
							newInput5.name = 'aptPrice';
							newInput5.value = object.get("price");
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
							theForm.appendChild(newInput2);
							theForm.appendChild(newInput3);
							theForm.appendChild(newInput4);
							theForm.appendChild(newInput5);
							theForm.appendChild(newInput6);
							theForm.appendChild(newInput7);
							// ...and it to the DOM...
							document.getElementById('hidden_form_container').appendChild(theForm);
							// ...and submit it
							theForm.submit();
							setTimeout(function(){location.reload(); },1000); 
						  },
						  error: function(error) {
							alert("Error: " + error.code + " " + error.message);
						  }
				});
		}
		
		function Deny(x) {
			Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");
			y = Math.floor(x/10);
			var g = "object" + y;
			var appointments = Parse.Object.extend("appointments");
			var query = new Parse.Query(appointments);
			query.equalTo("objectId", document.getElementById(g).value);
			query.first({
						success: function(object) {
							object.set("available", "taken");
							object.save();
							document.getElementById(x).disabled = true;
							document.getElementById(x).value = "Denying...";
							setTimeout(function(){location.reload(); },1000); 
						  },
						  error: function(error) {
							alert("Error: " + error.code + " " + error.message);
						  }
				});
		}

		$(function(){
		

			$('#notesModal').modal({
				show:false

			    }).on('show.bs.modal', function(event) {
			        var note = $(event.relatedTarget).data('notes');
			        document.getElementById("notes").value = note;
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