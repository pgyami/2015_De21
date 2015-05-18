<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link type="text/css" rel="stylesheet" href="public/css/bootstrap.css">

  <!--   <link type="text/css" rel="stylesheet" href="public/css/bootstrap.min.css"> -->
  <link type="text/css" rel="stylesheet" href="public/css/style.css">
  <script src ="public/js/bootstrap.js"></script>
  <script src ="public/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <style>
  body{
   background: no-repeat center center fixed; 
   -webkit-background-size: cover;
   -moz-background-size: cover;
   -o-background-size: cover;
   background-size: cover;
 }
 </style>
</head>
<body>
  <?php 
  $dbc_local = @mysqli_connect('localhost','root','123456');
  
  if (!empty($_POST['id'])){

    $id = $_POST['id'];
    $query = "SELECT * FROM userinfo.connection_info WHERE id=$id";
    $result = @mysqli_query($dbc_local, $query);
    $row = @mysqli_fetch_array($result);
    $_SESSION['hostname'] = $row['host'];
    $_SESSION['username'] = $row['user_name'];
    $_SESSION['password'] = $row['password'];
  }


  $dbc_user = @mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']); 
  if (mysqli_connect_errno())
  {
  /*echo "Failed to connect to MySQL: " . mysqli_connect_error();*/
  echo '<script>addAlert("danger","Failed to connect to MySQL");</script>';
  }

  if (isset($_GET['selecteddatabase']))
    $selecteddatabase = @mysqli_escape_string($dbc_user, $_GET['selecteddatabase']);
  if (isset($_GET['selectedtable']))
    $selectedtable = @mysqli_escape_string($dbc_user, $_GET['selectedtable']);

  if (empty($selecteddatabase) && empty($selectedtable)){
    $item_name_lsb = 'Databases';
    $item_name_content = 'Databases';
    $query_lsb = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";

    $type = 1;
    $result_lsb = @mysqli_query($dbc_user, $query_lsb);    

    $query_content = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";
    
  }
  elseif (isset($selecteddatabase) && empty($selectedtable)) {
      # code...
    $item_name_lsb = 'Databases';
    $item_name_content = 'Tables';
    $type = 2;  
    $query_content = "SHOW TABLES FROM $selecteddatabase";
    $result_content = @mysqli_query($dbc_user, $query_content);
    
    $query_lsb = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";
    $result_lsb = @mysqli_query($dbc_user, $query_lsb);

    $query_db = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";
    $result_db = @mysqli_query($dbc_user, $query_db);
    $exist_db = false;
    while ($row = @mysqli_fetch_array($result_db, MYSQLI_ASSOC)){
      $dbname = $row['SCHEMA_NAME'];
      if ($dbname == $selecteddatabase)
      {
        $exist_db = true;
        break;
      }
    }
    if (!$exist_db)
    {
      header("Location: index.php?action=show_404");
      die();
    }
    /*        @mysqli_data_seek($result_lsb, 0);*/
  }
  elseif (isset($selecteddatabase) && isset($selectedtable)) {
      # code...
    $item_name_lsb = 'Tables';
    $type = 3;
    if (isset($_GET['showstructure']))
      $showstructure = true;
    else $showstructure = false;
    $query_lsb = "SHOW TABLES FROM $selecteddatabase";
    $result_lsb = @mysqli_query($dbc_user, $query_lsb);

    $query_des = "DESC $selecteddatabase.$selectedtable";                
    $result_des = @mysqli_query($dbc_user, $query_des);

    $query_content = "SELECT * FROM $selecteddatabase.$selectedtable";
    if (!empty($_POST['filter_row'])){
      $filter_criteria = $_POST['query_filter2'];
      $query_content = "$query_content WHERE $filter_criteria";
                //echo $query_content;           
    }
    $exist_db = false;
    $exist_tb = false;
    $query_db = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";
    $result_db = @mysqli_query($dbc_user, $query_db);
    $query_tb = "SHOW TABLES FROM $selecteddatabase";
    $result_tb = @mysqli_query($dbc_user, $query_tb);

    while ($row = @mysqli_fetch_array($result_db, MYSQLI_ASSOC)){
      $dbname = $row['SCHEMA_NAME'];
      if ($dbname == $selecteddatabase)
      {
        $exist_db = true;
        break;
      }
    }
    if (!$exist_db)
    {
      header("Location: index.php?action=show_404");
      die();
    }

    while ($row = @mysqli_fetch_array($result_tb, MYSQLI_ASSOC)){
      $tbname = $row["Tables_in_$selecteddatabase"];
      if ($tbname == $selectedtable)
      {
        $exist_tb = true;
        break;
      }
    }
    if (!$exist_tb)
    {
      header("Location: index.php?action=show_404");
      die();
    }
    /*    @mysqli_data_seek($result_des, 0);*/

  }

  ?>
  <div id="wrapper" class="container">
    <div id="header">
      <?php
      require_once("admin/models/config.php");
      load_header();
      
      ?>
    </div>

    <div id="content" class="row"> 
      <h1 class="page-header">Dashboard</h1>
      <?php
      if ($type == 1) {
          # code...
        echo '<ol class="breadcrumb">';
        echo  '<li class="active">Home</li>';
        echo '</ol>';
      }
      elseif ($type == 2) {
          # code...
        echo '<ol class="breadcrumb">';
        echo    '<li><a href="index.php?action=manager_db">Home</a></li>';
        echo    '<li class="active">'.$selecteddatabase.'</li>';
        echo '</ol>';
      }
      elseif ($type == 3) {
          # code...
        echo '<ol class="breadcrumb">';
        echo    '<li><a href="index.php?action=manager_db">Home</a></li>';
        echo    '<li><a href="index.php?action=manager_db&selecteddatabase='.$selecteddatabase.'">'.$selecteddatabase.'</a></li>';
        echo    '<li class="active">'.$selectedtable.'</li>';
        echo '</ol>';
      }
      ?>

      <div class="col-sm-12">
        <?php
        load_lsidebar();
        load_widget('content-manager-db'); ?>
      </div>

      <div class="clearer"></div>
    </div>

    <!--    <hr> -->
    <div id="footer" class="row">
      <?php 
      load_footer();
      ?>
    </div>
  </div>
</body>
</html>
