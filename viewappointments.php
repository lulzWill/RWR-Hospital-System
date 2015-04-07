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
		echo    '<td class="active tableDiv"><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>';
	}
echo <<<EOL
        	</table>


            
        </div>
	</div>
</div>


<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
      </div>
          <div class="modal-body">
          <div class="form-group">
        <input class="form-control " type="text" placeholder="Mohsin">
        </div>
        <div class="form-group">
        
        <input class="form-control " type="text" placeholder="Irshad">
        </div>
        <div class="form-group">
        <textarea rows="2" class="form-control" placeholder="CB 106/107 Street # 11 Wah Cantt Islamabad Pakistan"></textarea>
    
        
        </div>
      </div>
          <div class="modal-footer ">
        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>
    
    
    
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Delete this appointment</h4>
      </div>
          <div class="modal-body">
       
       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this?</div>
       
      </div>
        <div class="modal-footer ">
        <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>







    		<script>
			    $( document ).ready(function() {

			        $('#myModal').on('show', function() {
					    var tit = $('.confirm-delete').data('title');

					    $('#myModal .modal-body p').html("Desea eliminar al usuario " + '<b>' + tit +'</b>' + ' ?');
					    var id = $(this).data('id'),
					    removeBtn = $(this).find('.danger');
					})

					$('.confirm-delete').on('click', function(e) {
					    e.preventDefault();

					    var id = $(this).data('id');
					    $('#myModal').data('id', id).modal('show');
					});

					$('#btnYes').click(function() {
					    // handle deletion here
					    var id = $('#myModal').data('id');
					    $('[data-id='+id+']').parents('tr').remove();
					    $('#myModal').modal('hide');
					    
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