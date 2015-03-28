<!DOCTYPE html>
<html lang="en">
  <nav class="navbar navbar-default  navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
	    <li><a class="navbar-brand" href="index.php">RWR</a></li>
        <li class="active"><a href="https://github.com/lulzWill/RWR-Hospital-System">GitHub <span class="sr-only">(current)</span></a></li>
        <li><a href="https://parse.com/apps/hospital-management-system--2/collections#class/_User">Parse DB</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
<?php
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	session_start();
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	ParseClient::setStorage( new ParseSessionStorage() );
	
	$currentUser = ParseUser::getCurrentUser();
	
	if($currentUser)
	{
		echo <<<EOL
			<li><a href="homepage.php">Home</a></li>
			<li><a href="viewprofile.php">View Profile</a></li>
			<li><a href="logoutcurusr.php">Log Out</a></li>
EOL;
	}
	else
	{
		echo <<<EOL
	    <form class="navbar-form navbar-left" method="POST" action="logincheck.php">
	      <div class="form-group">
			 <input type="email" class="form-control" id="username" name="username" placeholder="Email">
			 <input type="password" class="form-control" id="password" name="password" placeholder="Password">
	      </div>
	      <button type="submit" class="btn btn-default">Log In</button>
	    </form>
		<li><a href="signup.php">Sign Up</a></li>
EOL;
	}
	?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</html>