<div class="col-xs-4 col-sm-2 sidebar-offcanvas">
<?php 
    $item_name = "Contents";
    echo "<h3>List of ".$item_name."</h3>";

    $dbc = mysqli_connect('localhost','root','123456');
//if (empty($_SESSION['hostname'])){
    
    if (!empty($_POST['id'])){

      $id = $_POST['id'];
      $query = "SELECT * FROM userinfo.connection_info WHERE id=$id";
      $result = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($result);
      $_SESSION['hostname'] = $row['host'];
      $_SESSION['username'] = $row['user_name'];
      $_SESSION['password'] = $row['password'];
    } 
//}

    ?> 
    <?php 
    $dbc = mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);
    if (!$dbc){
      echo "Connection lost";
      exit(0);
    }
    ?>
<?php
    
    if (isset($_GET['selecteddatabase']))
        $selecteddatabase = mysqli_escape_string($dbc, $_GET['selecteddatabase']);
    if (isset($_GET['selectedtable']))
        $selectedtable = mysqli_escape_string($dbc, $_GET['selectedtable']);
    

    //Khong chon gi thi show chi db
    
    if (empty($selecteddatabase) && empty($selectedtable)){
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";
        $result = mysqli_query($dbc, $query);
        if (mysqli_num_rows($result) == 0) {
            echo "<ul class=\"nav nav-sidebar\">";
            "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul>";
        } else {
            echo "<ul class=\"nav nav-sidebar\">";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $dbname = $row['SCHEMA_NAME'];
                echo "<li><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a></li>";
            }
            echo "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul></div>";
        }
        
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";
        $result = mysqli_query($dbc, $query);
        if (mysqli_num_rows($result) == 0) {
            
        } else { 
            echo "<div class=\"col-xs-8 col-sm-8\">";
            echo "<div class=\"table-responsive\">";
            echo "<table class=\"table table-striped\"><thead><tr><td>DB name</td><td>Action</td></tr></thead>";
            
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $dbname = $row['SCHEMA_NAME'];
                echo "<tr><td><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a></td>";
                echo "<td><a href='index.php?action=delete_database&deletedatabase=$dbname'>Delete</a><td>";
                echo "</tr>";
            }
            echo "</tbody></table></div></div>";
        }
    }
    //Neu da chon database thi show cac table
    elseif (isset($selecteddatabase) && empty($selectedtable)){
        $_SESSION['selecteddatabase'] = $selecteddatabase;
        $query1 = "SHOW TABLES FROM $selecteddatabase";
        $result1 = mysqli_query($dbc, $query1);
        
        
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";
        $result = mysqli_query($dbc, $query);
        if (mysqli_num_rows($result) == 0) {
            echo "<ul class=\"nav nav-sidebar\">";
            "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul>";
        } else {
            echo "<ul class=\"nav nav-sidebar\">";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $dbname = $row['SCHEMA_NAME'];
                echo "<li><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a>";
                /*if ($dbname == $selecteddatabase){
                    echo "<ul class=\"nav nav-sidebar\">";
                        if (mysqli_num_rows($result1) != 0){
                        while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                            echo "<li>";
                            $tablename = $row["Tables_in_$selecteddatabase"];
                            echo "<a href='index.php?action=manager_db&selecteddatabase=$dbname&selectedtable=$tablename'>".$tablename."</a>";
                            echo "</li>";
                        }
                    }
                    echo "<li><a href='index.php?action=create_table&selecteddatabase=$dbname'>Create table</a></li>";
                    echo "</ul>";
                }*/
                echo "</li>";
            }
            echo "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul></div>";
        }
        
        $query1 = "SHOW TABLES FROM $selecteddatabase";
        $result1 = mysqli_query($dbc, $query1);
        if (mysqli_num_rows($result1) != 0){
            echo "<div class=\"col-xs-8 col-sm-8\">";
            echo "<div class=\"table-responsive\">";
            echo "<table class=\"table table-striped\"><thead><tr><th>Table name</th><th>Action</th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                $tablename = $row["Tables_in_$selecteddatabase"];
                echo "<tr>";
                echo "<td><a href='index.php?action=manager_db&selecteddatabase=$selecteddatabase&selectedtable=$tablename'>".$tablename."</a></td>";
                echo "<td><a href='index.php?action=delete_table&selecteddatabase=$selecteddatabase&deletetable=$tablename'>Delete table</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table></div></div>";
        }
        else{
            echo "<ul><a href='index.php?action=create_table'>Create table</a></ul>";
        }
    } 
    //Neu chon table thi show noi dung bang len
    elseif (isset($selecteddatabase) && isset($selectedtable)) {
        $_SESSION['selecteddatabase'] = $selecteddatabase;
        $query1 = "SHOW TABLES FROM $selecteddatabase";
        $result1 = mysqli_query($dbc, $query1);
        
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";
        $result = mysqli_query($dbc, $query);
        if (mysqli_num_rows($result) == 0) {
            echo "<ul class=\"nav nav-sidebar\">";
            "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul>";
        } else {
            //echo "<ul class=\"nav nav-sidebar\">";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $dbname = $row['SCHEMA_NAME'];
                //echo "<li><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a>";
                if ($dbname == $selecteddatabase){
                    if (mysqli_num_rows($result1) != 0){
                        echo "<ul class=\"nav nav-sidebar\">";
                        while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                            echo "<li>";
                            $tablename = $row["Tables_in_$selecteddatabase"];
                            echo "<a href='index.php?action=manager_db&selecteddatabase=$dbname&selectedtable=$tablename'>".$tablename."</a>";
                            echo "</li>";
                        }
                        echo "<li><a href='index.php?action=create_table'>Create table</a></li>";
                        echo "</ul></div>";
                    }
                }
               // echo "</li>";
            }
            /*echo "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul></div>";*/
        }
        //Kiem tra va them data
        $query = "DESC $selecteddatabase.$selectedtable";                
        $result = mysqli_query($dbc, $query);
        $check = false;
        while ($rows = mysqli_fetch_assoc($result)){
            $row = $rows['Field'];
            if (!empty($_POST[$row])){
                $check = true;
                break;
            }            
        }
        if ($check == true) {
            $query = "DESC $selecteddatabase.$selectedtable";                
            $result = mysqli_query($dbc, $query);
            $add = true;
            while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $row = $rows['Field'];
                if (empty($_POST[$row])){
                    $add = false;
                    break;
                }
            }
            if ($add == true){
                $query = "DESC $selecteddatabase.$selectedtable";                
                $result = mysqli_query($dbc, $query);
                $add = true;
                while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $row = $rows['Field'];
                    if (empty($_POST[$row])){
                        $add = false;
                        break;
                    }
                }
                $query1 = "INSERT INTO $selecteddatabase.$selectedtable VALUES (";
                $result = mysqli_query($dbc, $query);
                while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $row = $rows['Field'];
                    $query1 = $query1 . "'" . $_POST[$row] . "',";
                }
                $query1 = $query1 . ")";
                $query1 = str_replace(",)",")",$query1);
                $result = mysqli_query($dbc, $query1);
                if (mysqli_affected_rows($dbc) == 1){
                    echo "Them dong thanh cong";
                } else {
                    echo "Them dong that bai";
                }
            } else {
                echo "Nhap day du thong tin";
            }
        }
        
        if (!empty($_POST['delete_button'])){
            $delete_field = $_POST['delete_field'];
            $delete_value = $_POST['delete_value'];
            $query = "DELETE FROM $selecteddatabase.$selectedtable WHERE $delete_field='$delete_value'";
            $result = mysqli_query($dbc, $query);
            if (mysqli_affected_rows($dbc) == 1) {
                echo "Xoa dong thanh cong";
            } else {
                echo "Xoa dong that bai";
            }
        }
        
        //hien bang len
        $query = "DESC $selecteddatabase.$selectedtable";                
        $result = mysqli_query($dbc, $query);
        echo "<div class=\"col-xs-8 col-sm-10\">";
        echo "<div class=\"table-responsive\">";
        echo "<table class=\"table table-striped\" data-height=\"299\" data-sort-name=\"name\" data-sort-order=\"desc\"
        data-toolbar=\"#toolbar\"
           data-search=\"true\"
           data-show-refresh=\"true\"
           data-show-toggle=\"true\"
           data-show-columns=\"true\"
           data-show-export=\"true\"
           data-show-pagination-switch=\"true\"
           data-pagination=\"true\"
           data-page-list=\"[10, 25, 50, 100, ALL]\"
           data-show-footer=\"true\"
           data-side-pagination=\"server\"
           data-url=\"/examples/bootstrap_table/data\"
           data-response-handler=\"responseHandler\"><thead><tr>";
        
        $delete_field;
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            echo "<th data-sortable=\"true\">" . $row['Field'] . "</th>";
            $delete_field = $row['Field'];
        }
        echo "</tr></thead>";
        echo "<tbody>";
        $query = "SELECT * FROM $selecteddatabase.$selectedtable";
        $result = mysqli_query($dbc, $query);
        $num = mysqli_num_fields($result);
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            echo "<tr>";
            for ($i = 0; $i < $num; $i++){
                echo "<td>" . $row["$i"] . "</td>";
            }
            $num1 = $num - 1;
            $delete_value = $row["$num1"];
            echo "<form method='POST'>";
            echo "<td><button type='submit' name='delete_button' class='btn btn-success submit' value=\"Delete\">Delete</button></td>";
            echo "<td><input type='hidden' name='delete_field' value='$delete_field'></td>";
            echo "<td><input type='hidden' name='delete_value' value='$delete_value'></td>";
            echo "</form>";
            echo "</tr>";
        }
        
        
        //Hien hang cuoi cung
        echo "<form method='POST'>";
        $query = "DESC $selecteddatabase.$selectedtable";                
        $result = mysqli_query($dbc, $query);
        echo "<tr>";
        while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $row = $rows['Field'];
            echo "<td>" . "<input type=\"input\" class=\"form-control\" placeholder=\"$row\"  name='$row'>" . "</td>";

        }
        echo "<td><button type='submit' class='btn btn-primary submit' name='add_row' value=\"Add\">Add</button></td>";
        echo "</tr>";
        
        echo "</form>";
        
        echo "</tbody>";
        echo "</table>";  
        
    }
?>
  </div><!--/.sidebar-offcanvas-->   

