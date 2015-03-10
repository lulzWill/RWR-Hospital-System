
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>
  		Hospital Login Page
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="customcss.css" rel="stylesheet">
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

	<?php include_once("navbar.html"); ?>

    
  </head>
  <body>
	<body>
		
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

		<h1>
			RWR Hospital Management System
		</h1>
		<h2 id="title">
			Create an Account
		</h2>
		
		<form class="form-horizontal" action="signupuser.php" method="post" id="signupForm" onsubmit="return validateForm()">

			<div class="form-group">
				<label for="username" class="col-sm-2 control-label whitelabel">Email Address:</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="username" name="username" placeholder="Please enter your email address!" required>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label whitelabel">First Name:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Your First Name" required>
				</div>
			</div>
			<div class="form-group">
				<label for="lastname" class="col-sm-2 control-label whitelabel">Last Name:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Your Last Name" required>
				</div>
			</div>

			<div class="form-group">
				<label for="dateofbirth" class="col-sm-2 control-label whitelabel">Birthdate:</label>
				<div class="col-sm-2">
					<div class="input-group input-append date" id="dateRangePicker">
                		<input type="text" class="form-control" name="date" required/>
                		<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            		</div>
				</div>
			</div>

			<div class="form-group">
				<label for="role" class="col-sm-2 control-label whitelabel">Position:</label>
				<div class="col-sm-10 selectContainer">
		            <select class="form-control" name="role" required>
		                <option value="">Choose a position</option>
		                <option value="physician">Physician</option>
		                <option value="nurse">Nurse</option>
		                <option value="admin">Administrator</option>
		                <option value="patient">Patient</option>
		            </select>
		        </div>
			</div>

			<div class="form-group">
			    <label for="password" class="col-sm-2 control-label whitelabel">Password</label>
			    <div class="col-sm-10">
			      	<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
			    </div>
			</div>

			<div class="form-group">
			    <label for="confirmPassword" class="col-sm-2 control-label whitelabel">Confirm Password</label>
			    <div class="col-sm-10">
			      	<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Re-Enter Password" required>
			    </div>
			</div>

			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      	<button type="submit" class="btn btn-success">Sign Up</button>
					<a href="test.php"><label class="whitelabel hoverlight pad8left">Log In</label></a>
			    </div>
			</div>

		</form>

		

		<script>
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

			    $('#signupForm').validate({
				  rules: {
				    firstname: {
				      minlength: 3,
				      maxlength: 15,
				      required: true
				    },
				    lastname: {
				      minlength: 3,
				      maxlength: 15,
				      required: true
				    }
				  },
				  highlight: function(element) {
				    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
				  },
				  unhighlight: function(element) {
				    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
				  }
				});

			});

			function validateForm() {
			    var a = document.forms["signupForm"]["username"].value;
			    if (a == null || a == "") {
			        alert("Email must be filled out");
			        return false;
			    }

			    var b = document.forms["signupForm"]["firstname"].value;
			    if (b == null || b == "") {
			        alert("First name must be filled out");
			        return false;
			    }

			    var c = document.forms["signupForm"]["lastname"].value;
			    if (c == null || c == "") {
			        alert("Last name must be filled out");
			        return false;
			    }

			    var d = document.forms["signupForm"]["role"].value;
			    if (d == null || d == "") {
			        alert("Position must be selected");
			        return false;
			    }

			    var e = document.forms["signupForm"]["password"].value;
			    if (e == null || e == "") {
			        alert("Must enter a password");
			        return false;
			    }

			    var f = document.forms["signupForm"]["confirmPassword"].value;
			    if (f == null || f == "") {
			        alert("Re-enter your password");
			        return false;
			    }

			    var g = document.forms["signupForm"]["date"].value;
			    if (g == null || g == "") {
			        alert("Select a birthdate");
			        return false;
			    }
			}
		</script>

	</body>
  </body>
</html>

