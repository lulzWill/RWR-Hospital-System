<HTML>
<HEAD>
	<Title>Error: Must Validate Email</Title>
</HEAD>
<BODY>
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
		<link href="errMess.css" rel="stylesheet">
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
			
	  <?php include_once("navbar.php"); ?>
	  </head>
	  <body>
		<body>
			<div class="opbox h1">
				<p>
				ERROR: </br>Email is not Validated.
				</br>
				If you have not received an email yet, try checking your spam folder.
				</p>
				<div class="btn-group btn-group-justified" role="group" aria-label="...">
				  <div class="btn-group" role="group">
				    <a href="test.php" class="btn btn-default">Log In</a>
				  </div>
				  	<div class="btn-group" role="group">
				    	<a href="signup.php" class="btn btn-default">Sign Up</a>
				  	</div>
				  
				  	<div class="btn-group" role="group">
				    	<a href="resendconfirmation.php" class="btn btn-default">Resend Verification</a>
				  	</div>
				</div>
			</div>
		</body>

	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="js/bootstrap.min.js"></script>
	  </body>
	</html>
</BODY>
</HTML>