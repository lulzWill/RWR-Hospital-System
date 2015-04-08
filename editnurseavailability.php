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
	<link href="calendar.css" rel="stylesheet" type="text/css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->



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
	
	if($currentUser->get("position") == "nurse")
	{
		try {
			$query=new ParseQuery("Nurse");
			$query->equalTo("email", $currentUser->get("email"));
			$nurse=$query->first();
		}
		catch (ParseException $ex) {
	
		}
	}
	
	$date = time();
	$day = date('d', $date);
	$month = date('m', $date);
	$year = date('Y', $date);
	$amount_of_months = $month+1;
	for($month;$month<=$amount_of_months;$month++)
{
	$first_day = mktime(0,0,0,$month,1,$year);
	$title = date('F', $first_day);
	$day_of_week = date('D', $first_day);
	
	switch($day_of_week)
	{
		case "Sun": $blank = 0; break;
		case "Mon": $blank = 1; break;
		case "Tue": $blank = 2; break;
		case "Wed": $blank = 3; break;
		case "Thu": $blank = 4; break;
		case "Fri": $blank = 5; break;
		case "Sat": $blank = 6; break;
	}
	echo '</head><body><form class="form-horizontal" action="updatenurseavailability.php" method="post" id="editProfile1" onsubmit="return validateForm()">';
	$days_in_month = cal_days_in_month(0, $month, $year);
	echo '<table border=6 width=394>';
	echo '<tr style="margin: auto; background-color:yellow;"><th colspan=60>' . $title . ' ' . $year . '</th></tr>';
	echo '<tr><td width=62>S</td><<td width=62>M</td><td width=62>T</td><td width=62>W</td><td width=62>T</td><td width=62>F</td><td width=62>S</td></tr>';
	
	$day_count = 1;
	echo '<tr>';
	while ($blank > 0 )
	{
		echo '<td></td>';
		$blank = $blank-1;
		$day_count++;
	}
	$day_num=1;
	while ($day_num <= $days_in_month )
	{
		echo '<td>' . $day_num;
$workdays = $nurse->get("WDString");
$list = explode(" ", $workdays);
				
$checked="unchecked";
foreach($list as $j)
{
	if($day_num<10)
	{
		$currentday = $month . "/0" . $day_num;
	}
	else
	{
		$currentday = $month . "/" . $day_num;

	}
	if($currentday === $j)
	{
		$checked="checked";
	}
}
echo '<input type="checkbox" name="workdays[]" style="float: right;" value="' . $currentday . '"' . $checked . '></input></br>';
echo '</td>';
		$day_num++;
		$day_count++;
		if ($day_count > 7)
		{
			echo '</tr><tr>';
			$day_count=1;
		}
	}
	while ($day_count > 1 && $day_count <=7)
	{
		echo '<td></td>';
		$day_count++;
	}
	
	echo '</tr></table>';
}
echo '<div class="container">
			      	<button type="submit" class="btn btn-success">Save Schedule</button>
			    </div>
		</div></form></body>';
?>