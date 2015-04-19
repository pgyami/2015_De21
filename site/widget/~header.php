<!DOCTYPE html>
<html>
<head>
<title>Lab 6 - Responsive css</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
<link type="text/css" rel="stylesheet" href="../../public/css/bootstrap.css">
<script src ="../../public/js/bootstrap.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">BSLK Production</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <?php
        if(isUserLoggedIn()) {?>
      <ul class="nav navbar-nav navbar-right">
             <form class="navbar-form navbar-left" role="login">
				<div class="form-group" id="login_form">
                  <input type="text" class="form-control" placeholder="Username">
				  <input type="text" class="form-control" placeholder="Password">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			  </form>
      </ul>
      
        <?php
        }
        else{
            ?>
            <ul class="nav navbar-nav navbar-right">
             <form class="navbar-form navbar-left" role="login">
				<div class="form-group" id="login_form">
                  <input type="text" class="form-control" placeholder="Username">
				  <input type="text" class="form-control" placeholder="Password">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			  </form>
      </ul>
        <?php
        }
        ?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


 
</body>
</html>
