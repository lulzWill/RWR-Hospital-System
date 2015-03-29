<?php
echo <<<EOL
 
  <form class="col-sm-2" style="margin-left:9%;" method="POST" action="patientsearchlist.php">
    <div class="input-group">
      <input type="text" class="form-control" id="patientname" name="patientname" placeholder="John Doe">
        <button type="submit" class="btn btn-default">Go!</button>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</form>
EOL;

?>