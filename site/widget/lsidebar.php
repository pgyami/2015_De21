

<?php 
    


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
    <div id="content" class="row">  
    <?php
     //$dbc = mysqli_connect('localhost:3306','root','');
        if (isset($_GET['selecteddatabase']))
            $selecteddatabase = mysqli_escape_string($dbc, $_GET['selecteddatabase']);
        if (isset($_GET['selectedtable']))
            $selectedtable = mysqli_escape_string($dbc, $_GET['selectedtable']);
    if (!empty($selecteddatabase) && empty($selectedtable)){
        $item_name = "Databases";
        ?>
        
        <ol class="breadcrumb">
          <li><a href="index.php?action=manager_db">Home</a></li>
          <li class="active"><?php echo $selecteddatabase ?></li>
        </ol>
        <?php }
    else if (!empty($selecteddatabase) && !empty($selectedtable)) { 
        $item_name = "Tables";?>
        <ol class="breadcrumb">
          <li><a href="index.php?action=manager_db">Home</a></li>
          <li><a href="index.php?action=manager_db&selecteddatabase=<?php echo $selecteddatabase ?>"><?php echo $selecteddatabase ?></a></li>
          <li class="active"><?php echo $selectedtable ?></li>
        </ol>
        <?php }
    else if (empty($selecteddatabase) && empty($selectedtable)) { 
        $item_name = "Databases";?>
        <ol class="breadcrumb">
          <li class="active">Home</li>
        </ol>
        <?php } ?>
</div>
<div class="col-xs-4 col-sm-2 sidebar-offcanvas">
    <?php 
    $dbc = mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);
    if (!$dbc){
      echo "Connection lost";
      exit(0);
    }
    ?>
<?php
    echo "<h3>List of ".$item_name."</h3>";
    //Text choi thoi
    if (!empty($_POST['filter_row'])){
            $delete_field = $_POST['query_filter2'];
            
                echo "<script>addAlert(\"success\",\"$delete_field\");</script>";
            
        }

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
           /* echo "<li><a href='index.php?action=create_database'>Create database</a></li>";*/
            echo "</ul></div>";
        }
        
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";
        $result = mysqli_query($dbc, $query);
        if (mysqli_num_rows($result) == 0) {
            
        } else { 
            echo "<div class=\"col-xs-8 col-sm-8\">";
            echo '<button type="button" class="btn btn-info submit" ="Create Databases" onclick="location.href=\'index.php?action=create_database\';return false;">Create Databases</button><br/><br/>';
            echo '<div class="panel panel-info">';
            echo  '<div class="panel-heading">List of Databases</div>';
            echo  '<div class="panel-body">';
            echo "<div class=\"table-responsive\">";
            echo "<table class=\"table table-striped\"><thead><tr><th>DB name</th><td></td></tr></thead>";
            
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $dbname = $row['SCHEMA_NAME'];
                echo "<tr><td><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a></td>";
                /*echo "<td><a href='index.php?action=delete_database&deletedatabase=$dbname'>Delete</a><td>";*/
                echo '<td class=\'text-left\'><button type="button" class="btn btn-danger submit" value="Delete Table" onclick="location.href=\'index.php?action=delete_database&deletedatabase='.$dbname.'\';return false;">Delete</button></td>';

                echo "</tr>";
            }
            echo "</tbody></table></div></div></div>";
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
            /*echo "<li><a href='index.php?action=create_database'>Create database</a></li>";*/
            echo "</ul></div>";
        }
        
        $query1 = "SHOW TABLES FROM $selecteddatabase";
        $result1 = mysqli_query($dbc, $query1);

        echo "<div class=\"col-xs-8 col-sm-8\">";
        echo '<button type="button" class="btn btn-info submit" value="Create Table" onclick="location.href=\'index.php?action=create_table&selecteddatabase='.$selecteddatabase.'\';return false;">Create Table</button><br/><br/>';
        echo '<div class="panel panel-info">';
        echo '<div class="panel-heading">List of Tables</div>';
        echo '<div class="panel-body">';
        if (mysqli_num_rows($result1) != 0){           
            echo "<div class=\"table-responsive\">";
            echo "<table class=\"table table-striped\"><thead><tr><th>Table name</th><th></th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                $tablename = $row["Tables_in_$selecteddatabase"];
                echo "<tr>";
                echo "<td><a href='index.php?action=manager_db&selecteddatabase=$selecteddatabase&selectedtable=$tablename'>".$tablename."</a></td>";
               /* echo "<td><a href='index.php?action=delete_table&selecteddatabase=$selecteddatabase&deletetable=$tablename'>Delete table</a></td>";*/
               echo '<td class="text-left"><button type="button" class="btn btn-danger submit" value="Delete Table" onclick="location.href=\'index.php?action=delete_table&selecteddatabase='.$selecteddatabase.'&deletetable='.$tablename.'\';return false;">Delete</button></td>';

                echo "</tr>";
            }
            echo "</tbody></table></div>";
        }
        else{
            echo "This database have no table";
        }
        echo '</div></div>';
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
                       /* echo "<li><a href='index.php?action=create_table&selecteddatabase=$dbname'>Create table</a></li>";*/
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
                   echo "<script>addAlert(\"success\",\"Create record successfully\");</script>";
                } else {
                    echo "<script>addAlert(\"success\",\"Create record failed\");</script>";
                }
            } else {
                echo "<script>addAlert(\"success\",\"Please fill necessary infomation\");</script>";
            }
        }
        
        if (!empty($_POST['delete_button'])){
            $delete_field = $_POST['delete_field'];
            $delete_value = $_POST['delete_value'];
            $query = "DELETE FROM $selecteddatabase.$selectedtable WHERE $delete_field='$delete_value'";
            $result = mysqli_query($dbc, $query);
            if (mysqli_affected_rows($dbc) == 1) {
                echo "<script>addAlert(\"success\",\"Delete record successfully\");</script>";
            } else {
                echo "<script>addAlert(\"success\",\"Delete record failed\");</script>";
            }
        }

        
        
        //hien bang len
        $query = "DESC $selecteddatabase.$selectedtable";                
        $result = mysqli_query($dbc, $query);
        echo "<div class=\"col-xs-8 col-sm-10\">";
        echo '<div class="panel panel-info">';
        echo '<div class="panel-heading">Table Detail</div>';
        echo '<div class="panel-body">';
        echo "<div class=\"table-responsive\">";
        echo "<table class=\"table table-striped\" data-height=\"299\" data-sort-name=\"name\" data-sort-order=\"desc\"><thead><tr>";
        
        $delete_field = "dcmm";
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            echo "<th data-sortable=\"true\">" . $row['Field'] . "</th>";
            if ($delete_field == "dcmm")
                $delete_field = $row['Field'];
        }
        echo "</tr></thead>";
        echo "<tbody>";
        
        
        
        
        
        
        
        
        //Filter

        $query_filter = "DESC $selecteddatabase.$selectedtable";                
        $result_filter = mysqli_query($dbc, $query_filter);
        echo "<tr id =\"filter_row\">";
        $count5 = 0;
        while ($rows_filter = mysqli_fetch_array($result_filter, MYSQLI_ASSOC)){
            $count5++;
            $row_filter = $rows_filter['Field'];
            echo "<td>" . "<input type=\"input\"  class=\"form-control\" placeholder=\"$row_filter\" id=\"row_filter_$count5\"  name='$row_filter'>" . "</td>";

        }

        echo "<form method='POST'>";
        echo "<td class='text-left'><button type='submit' class='btn btn-success submit' id='ccc' name='filter_row' value=\"Filter\" onclick=\"getfilterQuery()\">Filter</button></td>";
        echo "<td><input type='hidden' id='query_filter2' name='query_filter2' value=''></td>";
        
        
        echo "</form>";
        echo "</tr>";
        //END - Filter
        
        
        
        
        
        
        $query = "SELECT * FROM $selecteddatabase.$selectedtable";
        $result = mysqli_query($dbc, $query);
        $num = mysqli_num_fields($result);
    
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            echo "<tr>";
            for ($i = 0; $i < $num; $i++){
                echo "<td>" . $row["$i"] . "</td>";
            }
            $num1 = $num - 1;
            $delete_value = $row["0"];
            echo "<form method='POST'>";
            echo "<td class='text-left'><button type='submit' name='delete_button' class='btn btn-danger submit' value=\"Delete\">Delete</button></td>";
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
        echo "<td class='text-left'><button type='submit' class='btn btn-primary submit' name='add_row' value=\"Add\">Add</button></td>";
        echo "</tr>";
        
        echo "</form>";
        
        echo "</tbody>";
        echo "</table>";
        echo '</div>';  
        
    }
?>
<script>
function getfilterQuery() {
    var filterrow= document.getElementById("filter_row");
    var c = filterrow.childNodes;
    var filter_query = "";
    for (i = 0; i < c.length-3; i++) {
        var filterrow_child2 = c[i].childNodes;
      //  txt = txt + filterrow_child2[0].value + "<br>";
    
    
                if(i == c.length-4)
            {
                
                if(filterrow_child2[0].value.length==0) 
                {
                   
                    filter_query = filter_query + filterrow_child2[0].name + " = *";
                }
                else
                {
                    filter_query = filter_query + filterrow_child2[0].name + " = " + " '" + filterrow_child2[0].value + "'";
                }
            }
            else
            {
                if(filterrow_child2[0].value.length==0) 
                {
                    filter_query = filter_query + filterrow_child2[0].name + " = * AND ";
                }
                else
                {
                    filter_query = filter_query + filterrow_child2[0].name + " = " + " '" + filterrow_child2[0].value + "'" + " AND ";
                }
            }
    
    }

    document.getElementById("query_filter2").value = filter_query;
}
</script>
  </div><!--/.sidebar-offcanvas-->   

