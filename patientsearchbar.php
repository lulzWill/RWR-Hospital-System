<?php
echo <<<EOL
 
  <form style="margin-left:10%;" method="POST" action="patientsearchlist.php">
      <input type="text" class="form-control" id="patientname" style="width: 50%;" name="patientname" placeholder="John Doe">
        <button type="submit" class="btn btn-success" style="float: right; margin-right: 50%;">Go!</button>
</form>
EOL;
?>