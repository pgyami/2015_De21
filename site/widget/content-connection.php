<!DOCTYPE html>
<html>
<head>
<?php $dbc = mysqli_connect('localhost','root','123456');?>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body> 
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
                    echo "<tr>
                      <td><input type='checkbox'></td>
                      <td>" . $row['id'] . "</td>
                      <td>" . $row['first_name'] . "</td>
                      <td>" . $row['last_name']. "</td>
                      <td>" . $row['user_name'] . "</td>
                      <td class='text-right'>
                        <div class='dropdown'>
                          <a data-toggle='dropdown' href='#'>Actions</a>
                          <ul class='dropdown-menu dropdown-menu-right' role='menu' aria-labelledby='dLabel'>
                            <li><a href='index.php?action=manager_db'>Manager db</a></li>
                            <li><a href='#'>Different Action</a></li>
                            <li><a href='#'>Another Option</a></li>
                            <li><a href='#'>Yet Another Action</a></li>
                          </ul>
                        </div>
                    </td>
                    </tr>";             
                }
                ?>
                <script>
                    
                </script>
              </tbody>
            </table>
            
          </div>
        </div>
      </div>
      
      <div class="panel panel-success">
        <div class="panel-heading hover-link" data-toggle="collapse" data-parent="false" data-target="#collapseTableTwo">
          <h4 class="panel-title">
            Create New Connection
          </h4>
        </div>
        <div id="collapseTableTwo" class="panel-collapse collapse">
          <div class="panel-body">
            
          </div>
        </div>
      </div>

      </div>
    </div>
</body>
</html>