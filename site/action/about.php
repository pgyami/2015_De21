<!DOCTYPE html>
<html>
<head>
<title>About</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
<link type="text/css" rel="stylesheet" href="public/css/bootstrap.css">
<script src ="public/js/bootstrap.js"></script>
<style>
body{
	  background: no-repeat center center fixed; 
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
require_once("admin/models/config.php");
 load_header();
 
 ?>

  <div class="row"> 
    <div class="col-sm-12">
	   <?php load_widget('content-about'); ?>
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