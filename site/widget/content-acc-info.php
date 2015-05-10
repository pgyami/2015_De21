<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="public/css/bootstrap-theme.min.css" />
</head>
<body>
<?php
global $loggedInUser;
?>
<div class="panel panel-primary">
      <div class="panel-heading">Your Account Settings</div>
      <div class="panel-body">
        <div class="form-group">
			<label class="col-sm-4 control-label">Title</label>
			<div class="col-sm-8">
			  <pre><?php echo $loggedInUser->title; ?></a></pre>
			</div>
		  </div>
        <div class="form-group">
			<label class="col-sm-4 control-label">ID</label>
			<div class="col-sm-8">
			  <pre><?php echo $loggedInUser->user_id; ?></a></pre>
			</div>
		  </div>
        <div class="form-group">
			<label class="col-sm-4 control-label">User name</label>
			<div class="col-sm-8">
			  <pre><?php echo $loggedInUser->username; ?></pre>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-4 control-label">Display name</label>
			<div class="col-sm-8">
			  <pre><?php echo $loggedInUser->displayname; ?></pre>
			</div>
		  </div>

		  <div class="form-group">
			<label class="col-sm-4 control-label">Email</label>
			<div class="col-sm-8" >
			  <pre><?php echo $loggedInUser->email; ?></pre>
			</div>
		  </div>

</div>
    </div>

</body>
</html>