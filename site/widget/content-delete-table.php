<?php $dbc = mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);?>
<form>
    <input type="hidden" name="action" value="delete_table" />
    <input type="hidden" name="deletetable" value="<?php echo $_GET['deletetable'];?>" />
    <input type="hidden" name="selecteddatabase" value="<?php echo $_GET['selecteddatabase'];?>" />
    Ban co muon xoa table <?php echo $_GET['deletetable']?>
    <input type="submit" name="cfmdelete" value="Yes"/>
</form>
<?php
    if (!empty($_GET['deletetable']) && !empty($_GET['selecteddatabase'])&& !empty($_GET['cfmdelete'])){
        $query = "DROP TABLE " . $_GET['selecteddatabase'] . "." . $_GET['deletetable'];
        $result = mysqli_query($dbc, $query);
        echo "Da xoa table";
    }
?>
<a href="index.php?action=manager_db">Quay ve trang quan ly</a>