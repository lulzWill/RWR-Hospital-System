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
  		Edit Users
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
	<body>
		<h1>
			Users
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
	$query->descending("position");
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
		
		<div class="modal fade" id="physicianModal" tabindex="-1" role="dialog" aria-labelledby="physicianModal" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="physModalLabel">Edit Physician</h4>
		      </div>

		      <div class="modal-body">
		      	<form class="form-horizontal" action="" method="" id="editProfile1" onsubmit="return validateForm()">
					<div class="profpic">
						<h4>User Information</h4>
						<div class="container">
						<div class="row">
							<div class="col-sm-10">
								<input type="hidden" class="form-control" id="email" name="email" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="firstName" class="col-sm-2 control-label whitelabel">First Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="firstName" name="firstName" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="lastName" class="col-sm-2 control-label whitelabel">Last Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="lastName" name="lastName" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="bday" class="col-sm-2 control-label whitelabel">Birthday:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="bday" name="bday" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="role" class="col-sm-2 control-label whitelabel">Position:</label>
							<div class="col-sm-10 selectContainer">
					            <select class="form-control" name="role" id="role" required>
					                <option value="nurse">Nurse</option>
					                <option value="admin">Administrator</option>
					                <option value="patient">Patient</option>
					                <option value="physician">Physician</option>
					            </select>
					        </div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="sex" class="col-sm-2 control-label whitelabel">Sex:</label>
							<div class="col-sm-10">
								<select class="form-control" name="sex" id="sex" name="sex" required>
					                <option value="Male">Male</option>
					                <option value="Female">Female</option>
					            </select>
							</div>
						</div>
						</div>
						<h4>Profile Picture</h4>
						<div class="container">
						<div class="row">
							<img src="" id="prof_pic_img" width="200" height="200"></img>		
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="prof_pic" class="col-sm-2 control-label whitelabel">Prof. Pic:</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="prof_pic" name="prof_pic" align="left" value="" required>
			                </div>			
						</div>
						</div>
					</div>
					<div class="continfo">
						<h4>Physician Information</h4>
						<div class="container">
						<div class="row">
							<label for="degree" class="col-sm-2 control-label whitelabel">Degree:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="degree" name="degree" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="school" class="col-sm-2 control-label whitelabel">University:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="school" name="school" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="years" class="col-sm-2 control-label whitelabel">Years of Experience:</label>
							<div class="col-sm-10">
								<input type="number" class="form-control" id="years" name="years" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="address" class="col-sm-2 control-label whitelabel">Work Address:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="address" name="address" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="citystate" class="col-sm-2 control-label whitelabel">City, State:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="citystate" name="citystate" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="zipcode" class="col-sm-2 control-label whitelabel">Zipcode:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="zipcode" name="zipcode" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="phone" class="col-sm-2 control-label whitelabel">Work/Office Phone:</label>
							<div class="col-sm-10">
								<input type="text" size="20" class="form-control" id="phone" name="phone" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<input type="button" class="btn btn-primary pull-right" id="btnSub" onclick="UpdatePhys()" value="Save Changes"/>
						</div>
						</div>
					</div>
					</form>
			  </div>	
		      </form>
		    </div>
		  </div>
		</div>

		<div class="modal fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModal" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="patModalLabel">Edit Patient</h4>
		      </div>

		      <div class="modal-body">
		      <form class="form-horizontal" action="" method="" id="editProfile2" onsubmit="return validateForm()">
					<div class="profpic">
						<h4>User Information</h4>
						<div class="container">
						<div class="row">
							<div class="col-sm-10">
								<input type="hidden" class="form-control" id="email_pat" name="email_pat" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="firstName_pat" class="col-sm-2 control-label whitelabel">First Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="firstName_pat" name="firstName_pat" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="lastName_pat" class="col-sm-2 control-label whitelabel">Last Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="lastName_pat" name="lastName_pat" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="bday_pat" class="col-sm-2 control-label whitelabel">Birthday:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="bday_pat" name="bday_pat" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="role_pat" class="col-sm-2 control-label whitelabel">Position:</label>
							<div class="col-sm-10 selectContainer">
					            <select class="form-control" name="role_pat" id="role_pat" required>
					                <option value="nurse">Nurse</option>
					                <option value="admin">Administrator</option>
					                <option value="patient">Patient</option>
					                <option value="physician">Physician</option>
					            </select>
					        </div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="sex_pat" class="col-sm-2 control-label whitelabel">Sex:</label>
							<div class="col-sm-10">
								<select class="form-control" name="sex_pat" id="sex_pat" required>
					                <option value="Male">Male</option>
					                <option value="Female">Female</option>
					            </select>
							</div>
						</div>
						</div>
						<h4>Profile Picture</h4>
						<div class="container">
						<div class="row">
							<img src="" id="prof_pic_img_pat" width="200" height="200"></img>		
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="prof_pic_pat" class="col-sm-2 control-label whitelabel">Prof. Pic:</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="prof_pic_pat" name="prof_pic_pat" align="left" value="" required>
			                </div>			
						</div>
						</div>
					</div>
					<div class="continfo">
						<h4>Patient Contact Information</h4>
							<div class="container">
							<div class="row">
								<label for="address" class="col-sm-2 control-label whitelabel">Address:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="address_pat" name="address_pat" value="" required>
				                </div>			
							</div>
							</div>
							<div class="container">
							<div class="row">
								<label for="citystate" class="col-sm-2 control-label whitelabel">City, State:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="citystate_pat" name="citystate_pat" value="" required>
								</div>
							</div>
							</div>
							<div class="container">
							<div class="row">
								<label for="zipcode" class="col-sm-2 control-label whitelabel">Zipcode:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="zipcode_pat" name="zipcode_pat" value="" required>
								</div>
							</div>
							</div>
							<div class="container">
							<div class="row">
								<label for="homephone" class="col-sm-2 control-label whitelabel">Home Phone:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="homephone" name="homephone" value="" required>
								</div>
							</div>
							</div>
							<div class="container">
							<div class="row">
								<label for="cellphone" class="col-sm-2 control-label whitelabel">Cell Phone:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="cellphone" name="cellphone" value="" required>
								</div>
							</div>
							</div>
						</div>
						<div class="emerginfo">
							<h4>Emergency Contact Information</h4>
							<h5>Primary</h5>
							<div class="container">
							<div class="row">
								<label for="emerg_name" class="col-sm-2 control-label whitelabel">Name:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="emerg_name" name="emerg_name" value="" required>
								</div>
							</div>
							</div>
							<div class="container">
							<div class="row">
								<label for="emerg_num" class="col-sm-2 control-label whitelabel">Number:</label>
								<div class="col-sm-10">
									<input type="text" size="8" class="form-control" id="emerg_num" name="emerg_num" value="" required>
								</div>
							</div>
							</div>
				            <div class="container">
							<div class="row">
								<label for="emerg_rel" class="col-sm-2 control-label whitelabel">Relation:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="emerg_rel" name="emerg_rel" value="" required>
								</div>
							</div>
							</div>
							<h5>Secondary</h5>
							<div class="container">
							<div class="row">
								<label for="emerg_name2" class="col-sm-2 control-label whitelabel">Name:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="emerg_name2" name="emerg_name2" value="" required>
								</div>
							</div>
							</div>
							<div class="container">
							<div class="row">
								<label for="emerg_num2" class="col-sm-2 control-label whitelabel">Number:</label>
								<div class="col-sm-10">
									<input type="text" size="8" class="form-control" id="emerg_num2" name="emerg_num2" value="" required>
								</div>
							</div>
							</div>
							<div class="container">
							<div class="row">
								<label for="emerg_rel2" class="col-sm-2 control-label whitelabel">Relation:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="emerg_rel2" name="emerg_rel2" value="" required>
								</div>
							</div>
							</div>
						</div>
						<h4>Medical Information</h4>
						<div class="container">
						<div class="row">
							<label for="insurance" class="col-sm-2 control-label whitelabel">Insurance:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="insurance" name="insurance" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="pre_conditions" class="col-sm-2 control-label whitelabel">Pre-Existing Conditions:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="pre_conditions" name="pre_conditions" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="medications" class="col-sm-2 control-label whitelabel">Medications:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="medications" name="medications" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="allergies" class="col-sm-2 control-label whitelabel">Allergies:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="allergies" name="allergies" value="" required>
							</div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<input type="button" class="btn btn-primary pull-right" id="btnSubPat" onclick="UpdatePat()" value="Save Changes"/>
						</div>
						</div>
					</div>
		      </form>
		    </div>
		  </div>
		</div>

		<div class="modal fade" id="nurseModal" tabindex="-1" role="dialog" aria-labelledby="nurseModal" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="nurModalLabel">Edit Nurse</h4>
		      </div>

		      <div class="modal-body">
				<form class="form-horizontal" action="" method="" id="editProfile3" onsubmit="return validateForm()">
					<div class="profpic">
						<h4>User Information</h4>
						<div class="container">
						<div class="row">
							<div class="col-sm-10">
								<input type="hidden" class="form-control" id="email_nur" name="email_nur" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="firstName_nur" class="col-sm-2 control-label whitelabel">First Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="firstName_nur" name="firstName_nur" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="lastName_nur" class="col-sm-2 control-label whitelabel">Last Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="lastName_nur" name="lastName_nur" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="bday_nur" class="col-sm-2 control-label whitelabel">Birthday:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="bday_nur" name="bday_nur" align="left" value="" required>
			                </div>			
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="role_nur" class="col-sm-2 control-label whitelabel">Position:</label>
							<div class="col-sm-10 selectContainer">
					            <select class="form-control" name="role_nur" id="role_nur" required>
					                <option value="nurse">Nurse</option>
					                <option value="admin">Administrator</option>
					                <option value="patient">Patient</option>
					                <option value="physician">Physician</option>
					            </select>
					        </div>
						</div>
						</div>
						<div class="container">
						<div class="row">
							<label for="sex_nur" class="col-sm-2 control-label whitelabel">Sex:</label>
							<div class="col-sm-10">
								<select class="form-control" name="sex_nur" id="sex_nur" required>
					                <option value="Male">Male</option>
					                <option value="Female">Female</option>
					            </select>
							</div>
						</div>
						</div>	      
						<div class="profpic">
							<h4>Profile Picture</h4>
							<div class="container">
							<div class="row">
								<img src="" id="prof_pic_img_nur" width="200" height="200"></img>		
							</div>
							</div>
							<div class="container">
							<div class="row">
								<label for="prof_pic_nur" class="col-sm-2 control-label whitelabel">Profile Picture Link:</label>
								<div class="col-sm-10">
									<input type="file" class="form-control" id="prof_pic_nur" name="prof_pic_nur" align="left" value="" required>
				                </div>			
							</div>
						</div>
						</div>
					<div class="continfo">
						<h4>Nurse Information</h4>
								<div class="container">
								<div class="row">
									<label for="degree_nur" class="col-sm-2 control-label whitelabel">Degree:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="degree_nur" name="degree_nur" value="" required>
					                </div>			
								</div>
								</div>
								<div class="container">
								<div class="row">
									<label for="school_nur" class="col-sm-2 control-label whitelabel">University:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="school_nur" name="school_nur" value="" required>
									</div>
								</div>
								</div>
								<div class="container">
								<div class="row">
									<label for="years_nur" class="col-sm-2 control-label whitelabel">Years of Experience:</label>
									<div class="col-sm-10">
										<input type="number" class="form-control" id="years_nur" name="years_nur" value="" required>
									</div>
								</div>
								</div>
								<div class="container">
								<div class="row">
									<label for="address_nur" class="col-sm-2 control-label whitelabel">Work Address:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="address_nur" name="address_nur" value="" required>
									</div>
								</div>
								</div>
								<div class="container">
								<div class="row">
									<label for="citystate_nur" class="col-sm-2 control-label whitelabel">City, State:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="citystate_nur" name="citystate_nur" value="" required>
									</div>
								</div>
								</div>
								<div class="container">
								<div class="row">
									<label for="zipcode_nur" class="col-sm-2 control-label whitelabel">Zipcode:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="zipcode_nur" name="zipcode_nur" value="" required>
									</div>
								</div>
								</div>
								<div class="container">
								<div class="row">
									<label for="phone_nur" class="col-sm-2 control-label whitelabel">Work/Office Phone:</label>
									<div class="col-sm-10">
										<input type="text" size="8" class="form-control" id="phone_nur" name="phone_nur" value="" required>
									</div>
								</div>
								<div class="container">
								<div class="row">
										<input type="button" class="btn btn-primary pull-right" id="btnSub_nur" onclick="UpdateNur()" value="Save Changes"/>
								</div>
								</div>
							</div>
					</form>
			  </div>
		      </form>
		    </div>
		  </div>
		</div>
	</body>




	<script type="text/javascript">

    	function UpdatePhys()
    	{
    		Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

			var usr = Parse.Object.extend("Physician");
			var query = new Parse.Query(usr);
			var curEmail = document.getElementById("email").value;

			query.equalTo("email", curEmail);
			query.first({
					  success: function(object) {
					  		if(document.getElementById("prof_pic").value != "")
					  		{
					  			var fileUploadControl = $("#prof_pic")[0];
					  			var file = fileUploadControl.files[0];

					  			var parseFile = new Parse.File("prof_pic.jpg", file);
					  			object.set("prof_pic", parseFile);
					  		}
					  		object.set("degree", document.getElementById("degree").value);
					  		object.set("school", document.getElementById("school").value);
					  		object.set("years", +document.getElementById("years").value);
					  		object.set("address", document.getElementById("address").value);
					  		object.set("citystate", document.getElementById("citystate").value);
					  		object.set("zipcode", document.getElementById("zipcode").value);
					  		object.set("phone", document.getElementById("phone").value);
					  		object.set("first_name", document.getElementById("firstName").value);
					  		object.set("last_name", document.getElementById("lastName").value);
					  		object.set("date_of_birth", document.getElementById("bday").value);

					  		object.save(null, {
					  				success: function(object) {
					  					document.getElementById("btnSub").disabled = true;
										document.getElementById("btnSub").value = "Please Wait...";
						    			Parse.User.become(document.getElementById("currSessionToken").value).then(function (user) {
										  // The current user is now set to user.
										  Parse.Cloud.run('modifyUser', {email: curEmail, firstname: document.getElementById("firstName").value, lastname: document.getElementById("lastName").value, 
																		dateOfBirth: document.getElementById("bday").value, position: document.getElementById("role").value, 
																		sex: document.getElementById("sex").value}, {
								    		success: function(status)
								    		{
								    			setTimeout(function() { 
								    					location.reload(); },1000); 
								    			
								    		},
								    		error: function(error)
								    		{
								    			console.log(error.message);
								    		}
								    		});
										}, function (error) {
										  // The token could not be validated.
										});
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

    	function UpdatePat()
    	{
    		Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

			var usr = Parse.Object.extend("Patient");
			var query = new Parse.Query(usr);
			var curEmail = document.getElementById("email_pat").value;

			query.equalTo("email", curEmail);
			query.first({
					  success: function(object) {
					  		
					  		if(document.getElementById("prof_pic_pat").value != "")
					  		{
					  			var fileUploadControl = $("#prof_pic_pat")[0];
					  			var file = fileUploadControl.files[0];

					  			var parseFile = new Parse.File("prof_pic.jpg", file);
					  			object.set("prof_pic", parseFile);
					  		}
					  		object.set("email", document.getElementById("email_pat").value);
					  		object.set("address", document.getElementById("address_pat").value);
					  		object.set("citystate", document.getElementById("citystate_pat").value);
					  		object.set("zipcode", document.getElementById("zipcode_pat").value);
					  		object.set("cellphone", document.getElementById("cellphone").value);
					  		object.set("homephone", document.getElementById("homephone").value);
					  		object.set("emerg_num", document.getElementById("emerg_num").value);
					  		object.set("emerg_name", document.getElementById("emerg_name").value);
					  		object.set("emerg_rel", document.getElementById("emerg_rel").value);
					  		object.set("emerg_num2", document.getElementById("emerg_num2").value);
					  		object.set("emerg_name2", document.getElementById("emerg_name2").value);
					  		object.set("emerg_rel2", document.getElementById("emerg_rel2").value);
					  		object.set("insurance", document.getElementById("insurance").value);
					  		object.set("pre_conditions", document.getElementById("pre_conditions").value);
					  		object.set("allergies", document.getElementById("allergies").value);
					  		object.set("medications", document.getElementById("medications").value);
					  		object.set("first_name", document.getElementById("firstName_pat").value);
					  		object.set("last_name", document.getElementById("lastName_pat").value);
					  		object.set("date_of_birth", document.getElementById("bday_pat").value);
					  		object.set("name", document.getElementById("firstName_pat").value.toLowerCase() + " " + document.getElementById("lastName_pat").value.toLowerCase());
					  		object.set("lower_last_name", document.getElementById("lastName_pat").value.toLowerCase());
					  		object.set("sex", document.getElementById("sex_pat").value);
					  		
					  		object.save(null, {
					  				success: function(object) {
					  					document.getElementById("btnSubPat").disabled = true;
					  					document.getElementById("btnSubPat").value = "Please Wait...";
						    			Parse.User.become(document.getElementById("currSessionToken").value).then(function (user) {
										  // The current user is now set to user.
										  Parse.Cloud.run('modifyUser', {email: curEmail, firstname: document.getElementById("firstName_pat").value, lastname: document.getElementById("lastName_pat").value, 
																		dateOfBirth: document.getElementById("bday_pat").value, position: document.getElementById("role_pat").value, 
																		sex: document.getElementById("sex_pat").value}, {
								    		success: function(status)
								    		{
								    			setTimeout(function() { 
								    					location.reload(); },1000);
								    		},
								    		error: function(error)
								    		{
								    			console.log(error.message);
								    		}
								    		});
										}, function (error) {
										  // The token could not be validated.
										});
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

    	function UpdateNur()
    	{
    		Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

			var usr = Parse.Object.extend("Nurse");
			var query = new Parse.Query(usr);
			var curEmail = document.getElementById("email_nur").value;

			query.equalTo("email", curEmail);
			query.first({
					  success: function(object) {
					  		if(document.getElementById("prof_pic_nur").value != "")
					  		{
					  			var fileUploadControl = $("#prof_pic_nur")[0];
					  			var file = fileUploadControl.files[0];

					  			var parseFile = new Parse.File("prof_pic.jpg", file);
					  			object.set("prof_pic", parseFile);
					  		}
					  		object.set("degree", document.getElementById("degree_nur").value);
					  		object.set("school", document.getElementById("school_nur").value);
					  		object.set("years", +document.getElementById("years_nur").value);
					  		object.set("address", document.getElementById("address_nur").value);
					  		object.set("citystate", document.getElementById("citystate_nur").value);
					  		object.set("zipcode", document.getElementById("zipcode_nur").value);
					  		object.set("phone", document.getElementById("phone_nur").value);
					  		object.set("first_name", document.getElementById("firstName_nur").value);
					  		object.set("last_name", document.getElementById("lastName_nur").value);
					  		object.set("date_of_birth", document.getElementById("bday_nur").value);
					  		object.set("sex", document.getElementById("sex_nur").value);

					  		object.save(null, {
					  				success: function(object) {
					  					document.getElementById("btnSub_nur").disabled = true;
					  					document.getElementById("btnSub_nur").value = "Please Wait...";
					  					Parse.User.become(document.getElementById("currSessionToken").value).then(function (user) {
										  // The current user is now set to user.
										  Parse.Cloud.run('modifyUser', {email: curEmail, firstname: document.getElementById("firstName_nur").value, lastname: document.getElementById("lastName_nur").value, 
																		dateOfBirth: document.getElementById("bday_nur").value, position: document.getElementById("role_nur").value, 
																		sex: document.getElementById("sex_nur").value}, {
								    		success: function(status)
								    		{
								    			setTimeout(function() { 
								    					location.reload(); },1000);
								    		},
								    		error: function(error)
								    		{
								    			console.log(error.message);
								    		}
								    		});
										}, function (error) {
										  // The token could not be validated.
										});
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