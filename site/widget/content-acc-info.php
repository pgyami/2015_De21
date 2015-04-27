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
echo "Username ";
echo $loggedInUser->username;
echo "</br>";
//global $loggedInUser;
echo "Display name ";
echo $loggedInUser->displayname;
echo "</br>";
echo "Group ";
echo $loggedInUser->title;
echo "</br>";
?>

</body>
</html>