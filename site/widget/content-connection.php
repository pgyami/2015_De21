<!DOCTYPE html>
<html>
<head>
<?php $dbc = mysqli_connect('localhost','root','123456');?>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css" />
  <!-- <link rel="stylesheet" type="text/css" href="public/css/style.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body> 
<?php
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['delete_submit'])) {
            $id = $_POST['id'];
            $query = "DELETE FROM userinfo.connection_info WHERE id='$id'";
            $result = mysqli_query($dbc, $query);
            if ($result) {
              # code...
              echo "<script>
                addAlert(\"success\",\"Delete connection successfully\");
                </script>";
            }
            else echo "<script>
                addAlert(\"danger\",\"Delete connection failed\");
                </script>";
        }
        if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['user']) && !empty($_POST['host'])) {
            $first_name = $_POST['first_name']; 
            $last_name = $_POST['last_name'];
            $user = $_POST['user'];
            $host = $_POST['host'];
            
             if(!empty($_POST['port']))
             {$port = $_POST['port'];
             $port=":$port";}
             else
             {$port='';
             }
            //$password = $_POST['password'];
            global $loggedInUser;
            $user_userforst = $loggedInUser->username;
            if (!empty($_POST['password'])) {
                $password = $_POST['password'];
            //echo "here ";
            $query = "INSERT INTO userinfo.connection_info(first_name, last_name,user_name, host, password, user_userforst) VALUES ('$first_name','$last_name','$user','$host$port','$password','$user_userforst') ";
            }
            else
            {
               // echo "here come";
            $query = "INSERT INTO userinfo.connection_info(first_name, last_name,user_name, host, password, user_userforst) VALUES ('$first_name','$last_name','$user','$host$port','','$user_userforst') ";    
            }

            try {
                $result = mysqli_query($dbc, $query);
            } catch (Exception $e) {
                echo '<script>addAlert("danger","'.$e->getMessage().'");</script>';
            }
            
            if (mysqli_affected_rows($dbc) == 1){
                echo "<script>
                addAlert(\"success\",\"Create connection successfully\");
                </script>";
            } else {

                echo "<script>
                addAlert(\"danger\",\"Error when create connection\");
                </script>";

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
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                  <th>Host</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                global $loggedInUser;
                $user_userforst = $loggedInUser->username;
                $query = "SELECT * FROM userinfo.connection_info WHERE user_userforst='$user_userforst'";
                $result = mysqli_query($dbc, $query);
                while ($row = mysqli_fetch_assoc($result)){
                    $id = $row['id'];
                    echo "<tr>
                    
                      <td>" . $row['first_name'] . "</td>
                      <td>" . $row['last_name']. "</td>
                      <td>" . $row['user_name'] . "</td>
                      <td>" . $row['host'] . "</td>
                      <td class='text-right'>
                        <form method='POST' id='frmConnection' name='frmConnection' action='index.php?action=homepage'>
                            <input type='hidden' name='id' value='$id'/>
                            <button type='submit' name='delete_submit' class='btn btn-danger submit' value=\"Delete\">Delete</button>
                        </form> 
                      </td>
                      <td class='text-left'>
                        <form method='POST' id='frmConnection' name='frmConnection' action='index.php?action=manager_db'>
                            <input type='hidden' name='id' value='$id'/>
                            <button type='submit' name='submit' class='btn btn-info submit' value=\"Manage\">Manage</button>
                        </form> 
                      </td>
                    </tr>";             

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
        <div class="panel-heading hover-link" data-toggle="collapse" data-parent="false" data-target="#collapseTableTwo" >
          <h4 class="panel-title">
            Create connection
          </h4>
        </div>
        <div id="collapseTableTwo" class="panel-collapse collapse">
          <div class="panel-body">
            <div class="col-sm-6">
              <form method="POST">
                      <div class='row'>
                    <div class='col-sm-12'>
                      <label class="col-sm-4 control-label">First Name</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
                          <input type="text" class="form-control" placeholder="First Name" aria-describedby="basic-addon1" name="first_name">
                          <?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("first_name",$errors)) echo "Required" ?>
                        </div>
                      </div>                    
                    </div>
                  </div>
                  <br />

                  <div class='row'>
                    <div class='col-sm-12'>
                      <label class="col-sm-4 control-label">Last Name</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
                          <input type="text" class="form-control" placeholder="Last Name" aria-describedby="basic-addon1" name="last_name">
                          <?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("last_name",$errors)) echo "Required" ?>
                        </div>
                      </div>                    
                    </div>
                  </div>
                  <br />

                  <div class='row'>
                    <div class='col-sm-12'>
                      <label class="col-sm-4 control-label">User Name</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
                          <input type="text" class="form-control" placeholder="User Name" aria-describedby="basic-addon1" name="user">
                          <?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("user",$errors)) echo "Required" ?>
                        </div>
                      </div>                    
                    </div>
                  </div>
                  <br />

                  <div class='row'>
                    <div class='col-sm-12'>
                      <label class="col-sm-4 control-label">Host</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
                          <input type="text" class="form-control" placeholder="Host" aria-describedby="basic-addon1" name="host">
                          <?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("host",$errors)) echo "Required" ?>
                        </div>
                      </div>                    
                    </div>
                  </div>
                  <br />
                  
                                    <div class='row'>
                    <div class='col-sm-12'>
                      <label class="col-sm-4 control-label">Port</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
                          <input type="text" class="form-control" placeholder="Port" aria-describedby="basic-addon1" name="port">
                          <?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("port",$errors)) echo "Required" ?>
                        </div>
                      </div>                    
                    </div>
                  </div>
                  <br />

                  <div class='row'>
                    <div class='col-sm-12'>
                      <label class="col-sm-4 control-label">Password</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-fw fa-key"></i></span>
                          <input type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" name="password">
                          <?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("password",$errors)) echo "Required" ?>
                        </div>
                      </div>                    
                    </div>
                  </div>
                  <br />

                  <div class='form-group'>
                    <div class='col-sm-12'>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type='submit' class='btn btn-success submit' value="Add connection">Add connection</button>
                        </div>
                      
                    </div>   
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      </div>
</body>
</html>