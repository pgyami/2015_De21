<div class="panel panel-success">
    <div class="panel-heading">Confirm delete table</div>
    <div class="panel-body">
        <?php
            $dbc = mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);
            if (!empty($_GET['deletetable']) && !empty($_GET['selecteddatabase'])&& !empty($_GET['cfmdelete'])){
                $query = "DROP TABLE " . $_GET['selecteddatabase'] . "." . $_GET['deletetable'];
                $result = mysqli_query($dbc, $query);
                echo '<script>addAlert("success","Delete table successfully");</script>';
                echo '<a href="index.php?action=manager_db&selecteddatabase='.$_GET['selecteddatabase'].'">Back to manager table page</a>';
            }
            else echo'
                <form>
                    <div class="row">
                        <div class="col-sm-3">
                            <input type="hidden" name="action" value="delete_table" />
                            <input type="hidden" name="deletetable" value="'.$_GET["deletetable"].'" />
                            <input type="hidden" name="selecteddatabase" value="'.$_GET["selecteddatabase"].'" />
                            Do you want to delete table '.$_GET["deletetable"].'
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-sm-3">
                            <!-- <input type="submit" name="cfmdelete" value="Yes"/> -->
                            <button type="submit" class="btn btn-info submit" name="cfmdelete" value="Yes">Yes</button>
                            <button type="button" class="btn btn-danger submit" onclick="location.href=\'index.php?action=manager_db&selecteddatabase='.$_GET['selecteddatabase'].'\'">No</button>
                        </div>
                    </div>
                </form>';
            
        ?>        
    </div>
</div>