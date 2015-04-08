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

	if($currentUser->get("position") != "patient")
	{
		header("Location: index.php");
	}
	else 
	{
		echo <<<EOL
  <!DOCTYPE html>
  <html lang="en">
  <head>
  	<title>
  		My Appointments
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="editprofile.css" rel="stylesheet">

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

    </head>
  <body>
	<body>
		<h1>
			Current Appointments
		</h1>

<!--
		<table class="table table-hover table-bordered table-condensed" style="margin-left: 10%; width: 80% !important;">
	 		<tr class="active">
	 			<th class="active tableDiv">Date</th>
	 			<th class="active tableDiv">Time</th>
				<th class="active tableDiv">Doctor</th>
	 		</tr>
EOL;
	$query = new ParseQuery("appointments");
	$query->equalTo("patientEmail", $currentUser->get("email"));
	$results = $query->find();

	for ($i = 0; $i < count($results); $i++) { 
  		$object = $results[$i];

  		$innerQuery = new ParseQuery("Physician");
  		$innerQuery->equalTo("email", $object->get("physicianEmail"));

  		$innerResults = $innerQuery->find();

  		echo '<tr class="active">';
	 	echo	'<td class="active tableDiv">' . $object->get("Date") . '</th>';
	 	echo	'<td class="active tableDiv">' . $object->get("Time") . '</th>';
		echo	'<td class="active tableDiv">Doctor ' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name") . '</th></tr>';
	}
echo <<<EOL
		</table>
-->




<!--

    		<div class="container">
			<div class="row">
		
   
        	<div class="col-md-12">
        	<div class="table-responsive">

                
        	<table id="mytable" class="table table-hover table-bordred table-condensed" style="margin-left: 10%; margin-top: 2%; width: 80% !important;">

        	<thead>
	        	<th class="active"><input type="checkbox" id="checkall" /></th>
	        	<th class="active">Date</th>
	        	<th class="active">Time</th>
	        	<th class="active">Doctor</th>
	        	<th class="active">Edit</th>
	        	<th class="active">Delete</th>
        	</thead>

        	
        	<tbody>
	        	<tr class="active">
	        	<!--
		        	<td><input type="checkbox" class="checkthis" /></td>
		        	<td class="active tableDiv"></td>
		        	<td class="active tableDiv"></td>
		        	<td class="active tableDiv"></td>
		        	<td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
		        	<td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
		        -->
		        </tr>
        	</tbody>


<!--
EOL;
	$query = new ParseQuery("appointments");
	$query->equalTo("patientEmail", $currentUser->get("email"));
	$results = $query->find();

	for ($i = 0; $i < count($results); $i++) { 
  		$object = $results[$i];

  		$innerQuery = new ParseQuery("Physician");
  		$innerQuery->equalTo("email", $object->get("physicianEmail"));

  		$innerResults = $innerQuery->find();

  		echo '<tr class="active">';
  		echo 	'<td><input type="checkbox" class="checkthis" /></td>';
	 	echo	'<td class="active tableDiv">' . $object->get("Date") . '</td>';
	 	echo	'<td class="active tableDiv">' . $object->get("Time") . '</td>';
		echo	'<td class="active tableDiv">Doctor ' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name") . '</td>';
		echo	'<td class="active tableDiv"><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>';
		echo    '<td class="active tableDiv"><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#myModal" ><span class="glyphicon glyphicon-trash"></span></button></p></td>';
	}
echo <<<EOL
        	</table>
-->


            
        </div>
	</div>
</div>




<table id="tbl">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Doctor</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

<!--
        <tr class="btnDelete" data-id="1">
            <td>Content1</td>
            <td><a href="#">View</a>

            </td>
            <td>Content2</td>
            <td>Active</td>
            <td>
                <button class="btnDelete" href="">delete</button>
            </td>
        </tr>
-->
    </tbody>

EOL;
	$query = new ParseQuery("appointments");
	$query->equalTo("patientEmail", $currentUser->get("email"));
	$results = $query->find();

	for ($i = 0; $i < count($results); $i++) { 
  		$object = $results[$i];

  		$innerQuery = new ParseQuery("Physician");
  		$innerQuery->equalTo("email", $object->get("physicianEmail"));

  		$innerResults = $innerQuery->find();


  		echo '<tr class="btnDelete" data-id=" '.$i.' " data-mydate=" '. $object->get("Date") .' " data-mytime=" '. $object->get("Time") .' " data-myemail=" '. $object->get("physicianEmail") .' ">';
	 	echo	'<td class="active tableDiv" >' . $object->get("Date") . '</td>';
	 	echo	'<td class="active tableDiv" >' . $object->get("Time") . '</td>';
		echo	'<td class="active tableDiv" >' . $innerResults[0]->get("first_name") . ' ' . $innerResults[0]->get("last_name") . '</td>';
		echo	'<td class="active tableDiv"><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" id="editButton" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="populateTimes()" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>';
		echo    '<td class="active tableDiv"><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btnDelete" data-title="Delete" data-target="#myModal" ><span class="glyphicon glyphicon-trash"></span></button></p></td>';
		echo '</tr>';


	}
echo <<<EOL

</table>


<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Reschedule your appointment</h4>
      </div>
        <div class="modal-body">
          		<div class="form-group">
					<label for="time" class="col-sm-12 control-label blacklabel">Select a new time:</label>
					<div class="col-sm-10 selectContainer">
						<select class="form-control" name="timeSelect" id="timeSelect" onchange="dateChange()" required>
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
      	</div>
        <div class="modal-footer ">
        	<button type="button" class="btn btn-success btn-lg" id="reschedule-event" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Reschedule</button>
        </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>
    
    
    
		    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                 <h3 class="modal-title" id="myModalLabel">Cancel Appointment</h3>

		            </div>
		            <div class="modal-body">
		                 <h4> Are you sure you want to cancel this?</h4>

		            </div>
		            <!--/modal-body-collapse -->
		            <div class="modal-footer">
		                <button type="button" class="btn btn-danger" id="btnDelteYes" href="#">Yes</button>
		                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		            </div>
		            <!--/modal-footer-collapse -->
		        </div>
		        <!-- /.modal-content -->
		    </div>
		    <!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->







    		<script>

    			function dateChange()
    			{
    				document.getElementById("dateSel").selectedIndex = document.getElementById("timeSelect").selectedIndex;
    			}

    			function deleteAppt(id, date, time, email) {

    					Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

	    				var appt = Parse.Object.extend("appointments");
						var query = new Parse.Query(appt);

						query.equalTo("Date", date);
						console.log(date);

						query.equalTo("Time", time);
						console.log(time);

						query.equalTo("physicianEmail", email);
						console.log(email);

						query.ascending("Date");


						query.find({

							  success: function(results) {
							  	alert("Successfully retrieved " + results.length + " appts.");
							  	for(var i = 0; i < results.length; i++)
							  	{

							  		
							  	}
							  },
							  error: function(error) {
							    alert("Error: " + error.code + " " + error.message);
							  }
						});
					 
    			}

    			function populateTimes() {
    				Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

    				var appt = Parse.Object.extend("appointments");
					var query = new Parse.Query(appt);

					//var email = document.getElementsByTagName("tr")[0];
					//console.log(email);

					var tbl = document.getElementById("tbl");
					var numRows = tbl.rows.length;

					for (var i = 1; i < numRows; i++) {
					    var ID = tbl.rows[i].id;
					    var cells = tbl.rows[i].getElementsByTagName('td');
					    for (var ic=0,it=cells.length;ic<it;ic++) {
					        // alert the table cell contents
					        // you probably do not want to do this, but let's just make
					        // it SUPER-obvious  that it works :)
					        alert(cells[ic].innerHTML);
					    }
					}

					query.equalTo("physicianEmail", "william-pruyn@uiowa.edu");
					query.ascending("Date");
					
					//document.scheduleApt.timeSelect.options.length = 0;
					//var option = document.createElement("option");
					//option.label = "Choose one";
					//document.scheduleApt.timeSelect.add(option);

					query.find({
						  success: function(results) {
						  		alert("Successfully retrieved " + results.length + " appts.");
						  	for(var i = 0; i < results.length; i++)
						  	{
						  		/*
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
						  		*/
						  	}
						  },
						  error: function(error) {
						    alert("Error: " + error.code + " " + error.message);
						  }
					});
    			}

			    $( document ).ready(function() {


					$('button.btnDelete').on('click', function (e) {
					    e.preventDefault();

					    var id = $(this).closest('tr').data('id');
					    var date = $(this).closest('tr').data('mydate');
					    var time = $(this).closest('tr').data('mytime');
					    var email = $(this).closest('tr').data('myemail');
					    $('#myModal').data('id', id);
					    $('#myModal').data('mydate', date);
					    $('#myModal').data('mytime', time);
					    $('#myModal').data('myemail', email);
					    $('#myModal').modal('show');
					});

					$('#btnDelteYes').click(function () {

						

					    var id = $('#myModal').data('id');
					    var date = $('#myModal').data('mydate');
					    var time = $('#myModal').data('mytime');
					    var email = $('#myModal').data('myemail');

					    
						deleteAppt(id, date, time, email);


						$("[data-id='" + id + "']").remove();
					    $('#myModal').modal('hide');

					});


				


					$('#reschedule-event').on('click',function(evt) {
						//update appointment time in parse
					});


					$("#mytable #checkall").click(function () {
					        if ($("#mytable #checkall").is(':checked')) {
					            $("#mytable input[type=checkbox]").each(function () {
					                $(this).prop("checked", true);
					            });

					        } else {
					            $("#mytable input[type=checkbox]").each(function () {
					                $(this).prop("checked", false);
					            });
					        }
					    });
					    
					    $("[data-toggle=tooltip]").tooltip();
			    });
		 
		    
		    </script>
	</body>
</html>
EOL;
}
?>