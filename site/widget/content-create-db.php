<?php $dbc = @mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);?>

<div class="panel panel-success">
	<div class="panel-heading">Create Database</div>
	<div class="panel-body">
		<form>
			<div class='row'>
				<div class='col-sm-6'>
					<label class="col-sm-4 control-label">Database name</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="hidden" name="action" value="create_database" />
							<span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
							<input type="text" class="form-control" placeholder="Database name" aria-describedby="basic-addon1" name="newdb">
						</div>
					</div>
				</div>
				<!-- 	          <input type="submit" value="Create db"/> -->
				<button type='submit' name='delete_button' class='btn btn-success submit' value="Create database">Create database</button>
			</div>

		</form>
	</div>
</div>
<?php
if (!empty($_GET['newdb'])){
	$query = "CREATE DATABASE " . $_GET['newdb'];
	$result = @mysqli_query($dbc, $query);
	if ($result) {		
		# code...
		echo "<script>
                addAlert(\"success\",\"Create database successfully\");
                </script>";
	}
	else {echo $result;
	 echo "<script>
                addAlert(\"danger\",\"Error when create database\");
                </script>";
            }
}
else '<script>addAlert(\"success\",\"Create database successfully\");</script>';
?>
<a href="index.php?action=manager_db"><button type="button" class="btn btn-default pull-right">Back to manager page</button></a>