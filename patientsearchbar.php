<?php
echo <<<EOL
 
  <form style="margin-left:10%;" method="POST" action="patientsearchlist.php">
      <input type="text" id="patientname" style="width: 40%;" name="patientname" placeholder="John Doe">
        <button type="submit" style="margin-left: 0%;" class="btn btn-primary">Go!</button>
</form>
EOL;
?>