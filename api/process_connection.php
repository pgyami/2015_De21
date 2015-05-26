<?php
require_once("../admin/models/config.php");

//session_start();
$dbc_local = @mysqli_connect('localhost','root','123456');
$errors = 0;
$successes = 0;
 if (!empty($_POST['id']) && (isUserLoggedIn())){
    global $loggedInUser;
    $user_userforst = $loggedInUser->username;
    $id = $_POST['id'];
    $query = "SELECT * FROM userinfo.connection_info WHERE id=$id";
    $result = @mysqli_query($dbc_local, $query);
    $row = @mysqli_fetch_array($result);

    if ($row['user_userforst'] == $user_userforst)
    {
      $_SESSION['hostname'] = $row['host'];
      $_SESSION['username'] = $row['user_name'];
      $_SESSION['password'] = $row['password'];
      $successes = 1;
    }
    else $errors = 1;
  }
  else $errors = 1;
  echo '{"errors" : '.$errors.',"successes" : '.$successes.'}';
?>