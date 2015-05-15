<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link type="text/css" rel="stylesheet" href="public/css/bootstrap.css">
  <script src ="public/js/bootstrap.js"></script>
  <script src="public/js/post_form.js"></script>
  <script src="code.jquery.com/jquery-1.11.3.min.js"></script>
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
  <div id="wrapper" class="container">
    <div id="header">
        <?php
        require_once("admin/models/config.php");
        load_header();
    
        ?>
    </div>

    <div id="content" class="row"> 

      <div class="col-sm-12">
        <?php
        load_lsidebar();
        //load_widget('content-manager-db'); ?>
      </div>

      <div class="clearer"></div>
    </div>
    <hr>
    <div id="footer">
      <?php 
      load_footer();
      ?>
    </div>
  </div>
</body>
</html>