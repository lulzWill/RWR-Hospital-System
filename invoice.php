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
  if($currentUser->get("position") == "patient")
  {
    try {
      $query=new ParseQuery("Patient");
      $query->equalTo("email", $currentUser->get("email"));
      $patient=$query->first();
      //error_log(print_r($patient,true));

     
    }
    catch (ParseException $ex) {
  
    }
    echo <<<EOL
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>
      My Billing
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    
  
  <!-- Include Parse Stuff -->
    <script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>

    </head>
  <body onload="init()" style="margin-top: 5%;">

    <div class="container">
    <div class="row">
        <div class="col-xs-12">
        <div class="invoice-title">
          <h2>Invoice</h2>
        <h3 class="pull-right" id="apptFor"> Appointment for 
EOL;
echo $currentUser->get("firstname");
echo " ";
echo $currentUser->get("lastname");
echo <<<EOL
        </h3>
        </div>
        <hr>
        <div class="row">
          <div class="col-xs-6">
            <address id="patientDetails">
            <strong>Patient Billing Information:</strong><br>
EOL;
echo $currentUser->get("firstname");
echo " ";
echo $currentUser->get("lastname");
echo <<<EOL
              <br> Sex: 
EOL;
echo $currentUser->get("sex");
echo <<<EOL
              <br> Date of Birth: 
EOL;
echo $currentUser->get("dateOfBirth");
echo <<<EOL
              <br> Address: 
EOL;
echo "<br>";
echo $patient->get("address");
echo "<br>";
echo $patient->get("citystate");
echo " ";
echo $patient->get("zipcode");
echo <<<EOL
              <br>     
            </address>
          </div>
          <div class="col-xs-6 text-right">
            <address>
              <strong>Specialist Seen:</strong><br>
              <div id="doctorDetails"></div>
            </address>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <address id="patientInsurance">
              <strong>Insurance:</strong><br>
EOL;
echo $patient->get("insurance");
echo <<<EOL
            </address>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <address id="patientEmail">
              <strong>Payment Method:</strong><br>
              Visa ending **** 0000<br>
EOL;
echo $patient->get("email");
echo <<<EOL
            </address>
          </div>
          <div class="col-xs-6 text-right">
            <address>
              <strong>Appointment Date:</strong><br>
              <div id="apptDate"></div><br><br>
            </address>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Appointment Summary</strong></h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-condensed">
                <thead>
                                <tr>
                      <td><strong>Reason</strong></td>
                      <td class="text-center"><strong>Date</strong></td>
                      <td class="text-center"><strong>Notes</strong></td>
                      <td class="text-right"><strong>Cost</strong></td>
                                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td id="reason">BS-200</td>
                    <td class="text-center" id="dateSum"></td>
                    <td class="text-center" id="notes"></td>
                    <td class="text-right" id="cost"></td>
                  </tr>
                  <tr>
                  
                    <td class="thick-line"></td>
                    <td class="thick-line"></td>
                    <td class="thick-line text-center"><!--<strong>Subtotal</strong>--></td>
                    <td class="thick-line text-right">-</td>
                  
                  </tr>
                  <tr>
                  
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line text-center"><!--<strong>Shipping</strong>--></td>
                    <td class="no-line text-right">-</td>

                  </tr>
                  <tr>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line text-center"><strong>Total</strong></td>
                    <td class="no-line text-right" id="total"></td>
                  </tr>
                </tbody>
              </table>


              <div class="text-right">
                <a href="#" class="btn btn-info" onclick="javascript:window.print();"><i class="fa fa-print"></i> Print</a>
                <a href="#" class="btn btn-success" id="pay_b" onclick="Update()"><i class="fa fa-usd"></i> Pay Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

 
  </body>

  <script type="text/javascript">
    function init() {
        document.getElementById("apptDate").innerHTML = sessionStorage.getItem("aDate");
        document.getElementById("dateSum").innerHTML = sessionStorage.getItem("aDate");
        document.getElementById("reason").innerHTML = sessionStorage.getItem("aReason");
        document.getElementById("notes").innerHTML = sessionStorage.getItem("aNotes");
        document.getElementById("cost").innerHTML = sessionStorage.getItem("aCost");
        document.getElementById("total").innerHTML = sessionStorage.getItem("aCost");

        Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

        var appt = Parse.Object.extend("Physician");
        var query = new Parse.Query(appt);
        
        query.equalTo("email", sessionStorage.getItem("docEmail"));

        query.find({
              success: function(results) {
                for(var i = 0; i < results.length; i++)
                {
                  document.getElementById("doctorDetails").innerHTML = 'Dr. ' + results[i].get("first_name") + ' ' + results[i].get("last_name");
                }
              },
              error: function(error) {
                alert("Error: " + error.code + " " + error.message);
              }
        });

        var getID = sessionStorage.getItem("apptID");
          // update appt to paid
        var appt2 = Parse.Object.extend("appointments");
        var query2 = new Parse.Query(appt2);
        query2.equalTo("objectId", getID);
        query2.first({
              success: function(results) {
                
                  if (results.get("paymentStatus") == 'paid') {
                      $('#pay_b').attr('disabled', true);
                      $('#pay_b').removeClass("btn-success").addClass("btn-default");
                      document.getElementById("pay_b").innerHTML = 'Paid. Thank You';
                  };
                
              },
              error: function(error) {
                alert("Error: " + error.code + " " + error.message);
              }
        });
    }

    function Update(){
      Parse.initialize("kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr", "dnSrc9MZjvPGuruDghO4imSb6OHqoJb3vyElTJAH");

      var currentUser = Parse.User.current();
      var getID = sessionStorage.getItem("apptID");
      // update appt to paid
      var appt = Parse.Object.extend("appointments");
      var query = new Parse.Query(appt);
      query.equalTo("objectId", getID);
      query.first({
        success: function(object) {

            object.set("paymentStatus", "paid");

          object.save(null, {
              success: function(object) {
              /*
              // update new appt to taken
              var theForm, newInput1, newInput2;
              // Start by creating a <form>
              theForm = document.createElement('form');
                theForm.action = 'notifyPaid.php';
                theForm.method = 'post';
                // Next create the <input>s in the form and give them names and values
              newInput1 = document.createElement('input');
                newInput1.type = 'hidden';
                newInput1.name = 'patientEmail';
                newInput1.value = object.get("patientEmail");
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
                theForm.appendChild(newInput5);
                theForm.appendChild(newInput6);
                theForm.appendChild(newInput7);
                // ...and it to the DOM...
                document.getElementById('hidden_form_container').appendChild(theForm);
                // ...and submit it
                document.getElementById('payButton').disabled = true;
                document.getElementById('payButton').value = "Please Wait";
                document.getElementById('closeBtn').disabled = true;
                theForm.submit(); 
                */
                
                var doctor = Parse.Object.extend("Physician");
                var docQuery = new Parse.Query(doctor);
                docQuery.equalTo("email", sessionStorage.getItem("docEmail"));
                var s = sessionStorage.getItem("aCost");
                while(s.charAt(0) === '$')
                    s = s.substr(1);
                docQuery.first({
                      success: function(results) {
                        var doctorPayout =  parseInt(s,10) * 0.8;
                        var pay = parseInt(doctorPayout,10) + results.get("apptBonuses");
                        results.set("apptBonuses", pay);
                        
                        results.save(null, {
              			  			success: function(object) {
              							   console.log("doc updated");
                               
                               var nurse = Parse.Object.extend("Nurse");
                                var nurseQuery = new Parse.Query(nurse);
                                nurseQuery.equalTo("email", sessionStorage.getItem("nEmail"));
                                var q = sessionStorage.getItem("aCost");
                                while(q.charAt(0) === '$')
                                    q = q.substr(1);
                                nurseQuery.first({
                                      success: function(results) {
                                        var nursePayout =  parseInt(q,10) * 0.2;
                                        var npay = parseInt(nursePayout,10) + results.get("apptBonuses");
                                        results.set("apptBonuses", npay);
                                        
                                        results.save(null, {
                              			  			success: function(object) {
                              							   console.log("nurse updated");
                                               sessionStorage.clear();
                              					
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
                               
              					 	     
              			  			},
              						  error: function(object, error) {
              						    // Execute any logic that should take place if the save fails.
              						    // error is a Parse.Error with an error code and message.
              						    alert('Failed to create new object, with error code: ' + error.message);
              						  }
              		    		});
                        
                      },
                      error: function(error) {
                        alert("Error ONE: " + error.code + " " + error.message);
                      }
                });
                
                /*
                var nurse = Parse.Object.extend("Nurse");
                var nurseQuery = new Parse.Query(nurse);
                nurseQuery.equalTo("email", sessionStorage.getItem("nEmail"));
                var q = sessionStorage.getItem("aCost");
                while(q.charAt(0) === '$')
                    q = q.substr(1);
                nurseQuery.first({
                      success: function(results) {
                        var nursePayout =  parseInt(q,10) * 0.2;
                        var npay = parseInt(nursePayout,10) + results.get("apptBonuses");
                        results.set("apptBonuses", npay);
                        
                        results.save(null, {
              			  			success: function(object) {
              							   console.log("nurse updated");
                               sessionStorage.clear();
              					
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
                */
                
                window.location.href = "viewbilling.php";
              },
              error: function(object, error) {
                // Execute any logic that should take place if the save fails.
                // error is a Parse.Error with an error code and message.
                alert('Failed to create new object, with error code: ' + error.message);
              }
            });

        },
        error: function(error) {
          alert("Error TWO: " + error.code + " " + error.message);
        }
      });
      
      }
  </script>

</html>
EOL;
}
?>
