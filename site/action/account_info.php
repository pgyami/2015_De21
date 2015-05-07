<!DOCTYPE html>
<html>
<head>
<title>Account Settings</title>
<style>
body{
	  background: url(background.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
</head>
<body>
<div class="container">
<?php
//require_once("admin/models/config.php");
 load_header();
 ?>
    

    <div class="row"> 
    <div class="col-sm-6">
		<?php
            load_widget('content-acc-info');
        ?>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-danger">
                <div class="panel-heading">Change Your Password/Email</div>
                <div class="panel-body">
                     <?php
                    load_widget('../../admin/account/account_settings');
                    ?>
                </div>
        </div>     
    </div>

	
    <div class="clearer"></div>
  </div>
  <hr>
  <div class="row">
            <?php 
                load_footer();
            ?>
        </div>
 
  </div>
</div>
</body>
</html>