<div class="col-sm-3">
</div>
<div class="col-sm-6">
<div class="panel panel-success">
	<div class="panel-heading">Confirm delete database</div>
	<div class="panel-body">
		<?php
			$dbc = @mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);
			if (isset($_GET['confirm']) && $_GET['confirm'] == "yes"){
				$deletedatabase = $_GET['deletedatabase'];
				$query = "DROP DATABASE $deletedatabase";
				$result = @mysqli_query($dbc, $query);
				echo '<script>addAlert("success","Delete database successfully");</script>';
				echo '<a href="index.php?action=manager_db">Back to manager page</a>';
			}
			else
				echo '<div class="row">
				<center>
						<h3>Do you want to delete database <a href="index.php?action=manager_db&selecteddatabase='.$_GET['deletedatabase'].'">'.$_GET['deletedatabase'].'</a></h3>
				</center>
				</div>
				<br />
				<div class="row">
				<center>
						<button type="button" class="btn btn-info submit" onclick="location.href=\'index.php?action=delete_database&deletedatabase='.$_GET['deletedatabase'].'&confirm=yes\';return false;">Yes</button>
						<button type="button" class="btn btn-danger submit" onclick="location.href=\'index.php?action=manager_db\'">No</button>
				</center>
				</div>
				<br />';

		?>
		
		
	</div>
</div>
</div>
<div class="col-sm-3">
</div>

								<!-- <a href="index.php?action=manager_db">No</a> -->
						<!-- <a href="index.php?action=delete_database&deletedatabase=<?php echo $_GET['deletedatabase'];?>&confirm=yes">Yes</a>  -->