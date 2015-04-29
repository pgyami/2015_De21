<?php 
$_SESSION['hostname'] = "localhost";
$_SESSION['username'] = "root";
$_SESSION['password'] = "123456";
?> 
<?php $dbc = mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);?>
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
            echo "<ul>";
            "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul>";
        } else {
            echo "<ul>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $dbname = $row['SCHEMA_NAME'];
                echo "<li><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a></li>";
            }
            echo "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul>";
        }
        
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA";
        $result = mysqli_query($dbc, $query);
        if (mysqli_num_rows($result) == 0) {
            
        } else {
            echo "<table><thead><tr><td>DB name</td><td>Action</td></tr></thead>";
            
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $dbname = $row['SCHEMA_NAME'];
                echo "<tr><td><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a></td>";
                echo "<td><a href='index.php?action=delete_database&deletedatabase=$dbname'>Delete</a><td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
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
            echo "<ul>";
            "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul>";
        } else {
            echo "<ul>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $dbname = $row['SCHEMA_NAME'];
                echo "<li><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a>";
                if ($dbname == $selecteddatabase){
                    if (mysqli_num_rows($result1) != 0){
                        echo "<ul>";
                        while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                            echo "<li>";
                            $tablename = $row["Tables_in_$selecteddatabase"];
                            echo "<a href='index.php?action=manager_db&selecteddatabase=$dbname&selectedtable=$tablename'>".$tablename."</a>";
                            echo "</li>";
                        }
                        echo "<li><a href='index.php?action=create_table&selecteddatabase=$dbname'>Create table</a></li>";
                        echo "</ul>";
                    }
                }
                echo "</li>";
            }
            echo "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul>";
        }
        
        $query1 = "SHOW TABLES FROM $selecteddatabase";
        $result1 = mysqli_query($dbc, $query1);
        if (mysqli_num_rows($result1) != 0){
            echo "<table><thead><tr><th>Table name</th><th>Action</th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                $tablename = $row["Tables_in_$selecteddatabase"];
                echo "<tr>";
                echo "<td><a href='index.php?action=manager_db&selecteddatabase=$selecteddatabase&selectedtable=$tablename'>".$tablename."</a></td>";
                echo "<td><a href='index.php?action=delete_table&selecteddatabase=$selecteddatabase&deletetable=$tablename'>Delete table</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
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
            echo "<ul>";
            "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul>";
        } else {
            echo "<ul>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $dbname = $row['SCHEMA_NAME'];
                echo "<li><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a>";
                if ($dbname == $selecteddatabase){
                    if (mysqli_num_rows($result1) != 0){
                        echo "<ul>";
                        while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                            echo "<li>";
                            $tablename = $row["Tables_in_$selecteddatabase"];
                            echo "<a href='index.php?action=manager_db&selecteddatabase=$dbname&selectedtable=$tablename'>".$tablename."</a>";
                            echo "</li>";
                        }
                        echo "<li><a href='index.php?action=create_table'>Create table</a></li>";
                        echo "</ul>";
                    }
                }
                echo "</li>";
            }
            echo "<li><a href='index.php?action=create_database'>Create database</a></li>";
            echo "</ul>";
        }
        
        $query = "DESC $selecteddatabase.$selectedtable";                
        $result = mysqli_query($dbc, $query);
        echo "<table><thead><tr>";
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            echo "<th>" . $row['Field'] . "</th>";
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
            echo "</tr>";
        }
        //Hang cuoi cung them data
        $query = "DESC $selecteddatabase.$selectedtable";                
        $result = mysqli_query($dbc, $query);
        echo "<table><thead><tr>";
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            echo "<th>" . $row['Field'] . "</th>";
        }
        echo "</tbody>";
        echo "</table>";   
    }
?>