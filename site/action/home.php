<!DOCTYPE html>
<html>
<head>
<title>Index</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
<link type="text/css" rel="stylesheet" href="public/css/bootstrap.css">
<script src ="public/js/bootstrap.js"></script>
<style>
body{
	  background:  no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
</head>
<body>
<div id="wrapper">
    <div id="header">
        <?php
        require_once("admin/models/config.php");
        if(isUserLoggedIn()) {
            ?>
                <script type="text/javascript">location.href = 'index.php?action=homepage';</script>       
            <?php                
            }
        load_header();
        ?>
    
        <div class="row">
                  <div id='display-alerts' class="col-lg-12">
        
                  </div>
        </div>
    </div>
    <div id="content" class="row"> 
        <div class="col-sm-6">
    		<?php
                load_widget('content-introduction');
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            load_widget('content_register');
             ?>
        </div>
        <div class="col-sm-12">
            <?php
            load_widget('content-about');
            ?>
        </div>
    	
        <div class="clearer"></div>
     </div>
      <hr>
     <div id="footer" class="row">
                <?php 
                    load_footer();
                ?>
     </div>
 
</div>
</body>
</html>