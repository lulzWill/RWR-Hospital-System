<?php 
    include_once("navbar.php");
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	ParseClient::setStorage( new ParseSessionStorage() );
	
	$currentUser = ParseUser::getCurrentUser();
	
	if($currentUser)
	{
		header("Location: homepage.php");
		exit;
		
	}
	else
	{
		echo <<<EOL
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
			<link href="test.css" rel="stylesheet">
		    <link href="css/bootstrap.min.css" rel="stylesheet">
			<link href="customcss.css" rel="stylesheet">
		    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		    <!--[if lt IE 9]>
		      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		    <![endif]-->
 		   </head>
  <body>
	<body>

		<h1>
			RWR Hospital Management System
		</h1>
		<h2>
			Sign In Please
		</h2>
		<form class="form-horizontal" action="logincheck.php" method="POST">
			<div class="form-group">
				<label for="username" class="col-sm-2 control-label whitelabel">Email Address:</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="username" name="username" placeholder="Please enter your email address!">
				</div>
			</div>
			<div class="form-group">
			    <label for="password" class="col-sm-2 control-label whitelabel">Password:</label>
			    <div class="col-sm-10">
			      	<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			    </div>
			</div>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      	<button type="submit" class="btn btn-default">Sign In</button>
					<a href="signup.php"><label class="whitelabel hoverlight pad8left">Sign Up</label></a>
			    </div>
			</div>
		</form>
	</body>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
EOL;
}
?>