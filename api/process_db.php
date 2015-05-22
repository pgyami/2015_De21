<?php
require_once("../admin/models/config.php");
// Start the session
//session_start();

// Check Post variables are available
if(isUserLoggedIn()) {
    if(isset($_POST['selecteddb']))
    {
        // Set session variables
        $_SESSION["selecteddb"] = $_POST['selecteddb'];
        echo '{"errors":0,"successes":1}';
    }
	}
    else{
        echo '{"errors":1,"successes":0}';
        //echo 'No, form submitted.';
        }
		echo $_SESSION['tsancut'];
		
	echo $_SESSION["selecteddb"];
?>
