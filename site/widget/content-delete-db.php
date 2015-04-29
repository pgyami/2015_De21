<?php $dbc = mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);?>
<?php echo "Ban muon xoa database " . $_GET['deletedatabase'];?>
<a href="index.php?action=delete_database&deletedatabase=<?php echo $_GET['deletedatabase'];?>&confirm=yes">Yes</a>
<a href="index.php?action=manager_db">No</a>
<?php
    
    if (isset($_GET['confirm']) && $_GET['confirm'] == "yes"){
        $deletedatabase = $_GET['deletedatabase'];
        $query = "DROP DATABASE $deletedatabase";
        $result = mysqli_query($dbc, $query);
        echo "Da xoa xong db";
    } 

?>
<a href="index.php?action=manager_db">Quay ve trang quan ly</a>
