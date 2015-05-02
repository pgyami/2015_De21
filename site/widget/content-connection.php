<!DOCTYPE html>
<html>
<head>
<?php $dbc = mysqli_connect('localhost','root','');?>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body> 
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['user']) && !empty($_POST['host']) && !empty($_POST['password'])) {
            $first_name = $_POST['first_name']; 
            $last_name = $_POST['last_name'];
            $user = $_POST['user'];
            $host = $_POST['host'];
            $password = $_POST['password'];
            $query = "INSERT INTO userinfo.connection_info(first_name, last_name,user_name, host, password) VALUES ('$first_name','$last_name','user','host','password') ";
            $result = mysqli_query($dbc, $query);
            if (mysqli_affected_rows($dbc) == 1){
                echo "Add user successfully";
            } else {
                echo "Error when insert";
            }
        }
    }
?>
<div class="panel-group">
      <div class="panel panel-info">
        <div class="panel-heading hover-link" data-toggle="collapse" data-parent="false" data-target="#collapseTableOne">
          <h4 class="panel-title">
            Your Connection List
          </h4>
        </div>
        <div id="collapseTableOne" class="panel-collapse collapse in">
          <div class="panel-body">
           <table class="table table-striped table-condensed table-hover">
              <thead>
                <tr>
                  <th><input type="checkbox"></th>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM userinfo.connection_info";
                $result = mysqli_query($dbc, $query);
                while ($row = mysqli_fetch_assoc($result)){
                    $id = $row['id'];
                    echo "<form method='POST' id='frmConnection' name='frmConnection' action='index.php?action=manager_db'><tr>
                        <input type='hidden' name='id' value='$id'/>
                      <td><input type='checkbox'></td>
                      <td>" . $row['id'] . "</td>
                      <td>" . $row['first_name'] . "</td>
                      <td>" . $row['last_name']. "</td>
                      <td>" . $row['user_name'] . "</td>
                      
                      <td class='text-right'>
                        <div class='dropdown'>
                          <a data-toggle='dropdown' href='#'>Actions</a>
                          <ul class='dropdown-menu dropdown-menu-right' role='menu' aria-labelledby='dLabel'>
                            <li><input type='submit' name='submit' value='Manager this db'></li>
                          </ul>
                        </div>
                    </td>
                    </tr></form>";             
                }
                ?>
                <script>
                    $('#clickme').click(function(){
                        //$('#frmConnection').submit();
                        //$(location).attr('http://localhost/2015_De21/index.php?action=manager_db',url);
                        //window.location.href = "index.php?action=manager_db";
                    });
                    
                </script>
              </tbody>
            </table>
            
          </div>
        </div>
      </div>
      
      <div class="panel panel-success">
        <div class="panel-heading hover-link" data-toggle="collapse" data-parent="false" data-target="#collapseTableTwo">
          <h4 class="panel-title">
            Create connection
          </h4>
        </div>
        <div id="collapseTableTwo" class="panel-collapse collapse">
          <div class="panel-body">
            <form method="POST">
                First name: <input type="input" name="first_name"/><?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("first_name",$errors)) echo "Required" ?><br />
                Last name: <input type="input" name="last_name"/><?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("last_name",$errors)) echo "Required" ?><br />
                Username: <input type="input" name="user"/><?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("user",$errors)) echo "Required" ?><br />
                Host: <input type="input" name="host"/><?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("host",$errors)) echo "Required" ?><br />
                Password: <input type="input" name="password"/><?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("password",$errors)) echo "Required" ?><br />
                <input type="submit" value="Add connection"/>
            </form>
          </div>
        </div>
      </div>

      </div>
    </div>
</body>
</html>