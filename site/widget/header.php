
<!DOCTYPE html>
<html>
<head>
<?php
global $email_login;

if ($email_login == 1) {
    $user_email_placeholder = 'Username or Email';
}else{
    $user_email_placeholder = 'Username';
}
?>

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
        if(!isUserLoggedIn()) {?>
      <ul class="nav navbar-nav navbar-right">
             <form class="navbar-form navbar-left" role='form' name='login' action='admin/api/process_login.php' method='post'>
				<div class="form-group" id="login_form">
                  <input type="text" class="form-control" id="inputUserName" placeholder="<?php echo $user_email_placeholder; ?>" name = 'username' value=''>
				  <input type="password" class="form-control" id="inputPassword" placeholder="Password" name='password'>
				</div>
				<button type="submit" class="btn btn-default" value='Login'>Submit</button>
			  </form>
      </ul>
      
        <?php
        }
        else{
            ?>
            <ul class="nav navbar-nav navbar-right">
                <li class=""><a href="#" target="_blank">Username: Locdinh Pro</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        <?php
        }
        ?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<script>
        $(document).ready(function() {          
		  // Load navigation bar
		  $(".navbar").load("header-loggedout.php", function() {
			  $(".navbar .navitem-login").addClass('active');
		  });
		  // Load jumbotron links
		  $(".jumbotron-links").load("jumbotron_links.php");
	  
		  alertWidget('display-alerts');
			  
		  $("form[name='login']").submit(function(e){
			var form = $(this);
			var url = 'admin/api/process_login.php';
			$.ajax({  
			  type: "POST",  
			  url: url,  
			  data: {
				username:	form.find('input[name="username"]').val(),
				password:	form.find('input[name="password"]').val(),
				ajaxMode:	"true"
			  },		  
			  success: function(result) {
				var resultJSON = processJSONResult(result);
				if (resultJSON['errors'] && resultJSON['errors'] > 0){
				  alertWidget('display-alerts');
				} else {
				  window.location.replace("admin/account");
				}
			  }
			});
			// Prevent form from submitting twice
			e.preventDefault();
		  });
		  
		});
	</script>

 
</body>
</html>
