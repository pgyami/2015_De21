<?php
require_once("../admin/models/config.php");
$dbc_local = @mysqli_connect('localhost','root','123456');
$errors = 0;
$successes = 0;
 if (!empty($_POST['id']) /*&& (isUserLoggedIn())*/){

    $id = $_POST['id'];
    $query = "SELECT * FROM userinfo.connection_info WHERE id=$id";
    $result = @mysqli_query($dbc_local, $query);
    $row = @mysqli_fetch_array($result);
    $_SESSION['hostname'] = $row['host'];
    $_SESSION['username'] = $row['user_name'];
    $_SESSION['password'] = $row['password'];
    $successes = 1;
  }
  else $errors = 1;
  echo '{"errors" : '.$errors.',"successes" : '.$successes.'}';

?>