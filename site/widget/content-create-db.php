<?php $dbc = mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);?>
<form>
    <input type="hidden" name="action" value="create_database" />
    <input type="text" name="newdb"/>
    <input type="submit" value="Create db"/>
</form>
<?php
    if (!empty($_GET['newdb'])){
        $query = "CREATE DATABASE " . $_GET['newdb'];
        $result = mysqli_query($dbc, $query);
    }
?>
<a href="index.php?action=manager_db">Quay ve trang quan ly</a>