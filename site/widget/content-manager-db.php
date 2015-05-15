<?php
  global $result_lsb;
  global $type;
  global $query_content;
  global $query_des;
  global $selecteddatabase;
  global $selectedtable;
  global $dbc_user;
  global $showstructure;

  $create_database_button = '<button type="button" class="btn btn-info submit" value="Create Databases" onclick="location.href=\'index.php?action=create_database\';return false;">Create Databases</button><br/><br/>';
  $create_table_button = '<button type="button" class="btn btn-info submit" value="Create Table" onclick="location.href=\'index.php?action=create_table&selecteddatabase='.$selecteddatabase.'\';return false;">Create Table</button><br/><br/>';
  $show_table_structure_button = '<button type="button" class="btn btn-info submit" value="Show Structure" onclick="location.href=\'index.php?action=manager_db&selecteddatabase='.$selecteddatabase.'&selectedtable='.$selectedtable.'&showstructure=yes\';return false;">Show Structure</button><br/><br/>';
  $show_table_data_button = '<button type="button" class="btn btn-info submit" value="Show Data" onclick="location.href=\'index.php?action=manager_db&selecteddatabase='.$selecteddatabase.'&selectedtable='.$selectedtable.'\';return false;">Show Data</button><br/><br/>';
?>
<div class="col-sm-10">

<!--   <div class="row placeholders"> -->
     <div class="col-xs-12 col-sm-12">
        <?php
           if ($type == 1) {
            # code...
              echo $create_database_button;
            }
            elseif ($type == 2) {
              # code...
              echo $create_table_button;
            }
            elseif ($type == 3) {
              # code...
              if (!$showstructure) {
                # code...
                echo $show_table_structure_button;
              }
              else
                echo $show_table_data_button;
              
            }
        ?>
        <div class="panel panel-info">
            <div class="panel-heading">
              <?php 

              //hien ten cua panel
                if ($type == 1) {
                # code...
                  echo 'List of databases';
                }
                elseif ($type == 2) {
                  # code...
                  echo 'List tables in database '.$selecteddatabase;
                }
                elseif ($type == 3) {
                  # code...
                  echo 'Data in Table '.$selectedtable;
                }
             ?>
            </div>
              <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                     <thead>
                      <?php 

                      //hien ten cot cua bang
                      if ($type == 3) {
                        # code...
                        $result_des = @mysqli_query($dbc_user, $query_des);
                        if (!$showstructure){
                          echo '<tr>';
                          
                          while ($row = @mysqli_fetch_array($result_des, MYSQLI_ASSOC))
                            echo '<th>' . $row['Field'] . '</th>';

                            echo '<th></th>';
                            echo '</tr>';
                        }
                        else {
                          echo '<tr>';                       
                            echo '<th>Field</th>';
                            echo '<th>Type</th>';
                            echo '<th>Null</th>';
                            echo '<th>Key</th>';
                            echo '<th>Default</th>';
                            echo '<th>Extra</th>';
                            echo '</tr>';
                        }
                      }
                      elseif ($type == 1) {
                        # code...
                        echo '<tr>';
                        echo '<th>Database name</th><th></th>';
                        echo '</tr>';
                      }
                      else echo '<tr><th>Table name</th><th></th></tr>';
                      ?>                                             
                     </thead>          
                     <tbody>
                        <?php

                        //them du lieu vao bang

                        $result_des = @mysqli_query($dbc_user, $query_des);
                        $check = false;
                        while ($rows = @mysqli_fetch_assoc($result_des)){
                            $row = $rows['Field'];
                            if (!empty($_POST[$row])){
                                $check = true;
                                break;
                            }            
                        }
                        if ($check == true) {
                            $result_des = @mysqli_query($dbc_user, $query_des);
                            $add = true;
                            while ($rows = @mysqli_fetch_array($result_des, @MYSQLI_ASSOC)){
                                $row = $rows['Field'];
                                if (empty($_POST[$row])){
                                    $add = false;
                                    break;
                                }
                            }
                            $add = true;
                            if ($add == true){
                                $result_des = @mysqli_query($dbc_user, $query_des);
                                $add = true;
                                while ($rows = @mysqli_fetch_array($result_des, @MYSQLI_ASSOC)){
                                    $row = $rows['Field'];
                                    if (empty($_POST[$row])){
                                        $add = false;
                                        break;
                                    }
                                }
                                $query_insert = "INSERT INTO $selecteddatabase.$selectedtable VALUES (";
                                $result_des = @mysqli_query($dbc_user, $query_des);
                                while ($rows = @mysqli_fetch_array($result_des, @MYSQLI_ASSOC)){
                                    $row = $rows['Field'];
                                    $query_insert = $query_insert . "'" . $_POST[$row] . "',";
                                }
                                $query_insert = $query_insert . ")";
                                $query_insert = str_replace(",)",")",$query_insert);
                                $result = @mysqli_query($dbc_user, $query_insert);
                                $error =  mysqli_error($dbc_user);
                                if (@mysqli_affected_rows($dbc_user) == 1){
                                   echo "<script>addAlert(\"success\",\"Create record successfully\");</script>";
                                } else {
                                    echo "<script>addAlert(\"danger\",\"".$error."\");</script>";
                                }
                            } else {
                                echo "<script>addAlert(\"danger\",\"Please fill necessary infomation\");</script>";
                            }
                        }

                        //hien noi dung bang

                        if ($type == 1) {
                            # code...
                          $result_content = @mysqli_query($dbc_user, $query_content);
                          if (@mysqli_num_rows($result_content) != 0){ 
                            while ($row = @mysqli_fetch_array($result_content, MYSQLI_ASSOC)){
                              $dbname = $row['SCHEMA_NAME'];
                              echo "<tr><td><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a></td>";
                              echo '<td class="text-left"><button type="button" class="btn btn-danger submit" value="Delete Database" onclick="location.href=\'index.php?action=delete_database&deletedatabase='.$dbname.'\';return false;">Delete</button></td>';
                              echo "</tr>";
                            }
                          }
                          else echo "There is no database";
                        }
                        elseif ($type == 2) {
                            # code...
                          $result_content = @mysqli_query($dbc_user, $query_content);
                          if (@mysqli_num_rows($result_content) != 0){ 
                             while ($row = @mysqli_fetch_array($result_content, MYSQLI_ASSOC)){
                                $tablename = $row["Tables_in_$selecteddatabase"];
                                echo "<tr>";
                                echo "<td><a href='index.php?action=manager_db&selecteddatabase=$selecteddatabase&selectedtable=$tablename'>".$tablename."</a></td>";
                                echo '<td class="text-left"><button type="button" class="btn btn-danger submit" value="Delete Table" onclick="location.href=\'index.php?action=delete_table&selecteddatabase='.$selecteddatabase.'&deletetable='.$tablename.'\';return false;">Delete</button></td>';
                                echo "</tr>";
                              }
                            }
                            else echo "This database have no table";
                        }
                        elseif ($type == 3) {
                          # code...
                          if (!$showstructure) {
                            # code...
                          
                            $result_content = @mysqli_query($dbc_user, $query_content);
                            $num_of_fields = @mysqli_num_fields($result_content);
                            while ($row = @mysqli_fetch_array($result_content, MYSQLI_NUM)){
                                echo "<tr>";
                                for ($i = 0; $i < $num_of_fields; $i++){
                                    echo "<td>" . $row["$i"] . "</td>";
                                }
                               /* $num1 = $num_of_fields - 1;*/
                               echo "<td class='text-left'><button type='submit' name='delete_button' class='btn btn-danger submit' value=\"Delete\">Delete</button></td>";
                            }
                            echo '</tr>';
                            echo '<form method="POST">';
                            echo '<tr>';

                            $result_des = @mysqli_query($dbc_user, $query_des);
                            while ($row = @mysqli_fetch_array($result_des, MYSQLI_ASSOC)){
                              echo '<td><input type="input" class="form-control" placeholder="'.$row['Field'].'"  name="'.$row['Field'].'"></td>';
                            }

                            
                            echo "<td class='text-left'><button type='submit' class='btn btn-primary submit' name='add_row' value=\"Add\">Add</button></td>";
                            echo '</tr>';
                            echo "</form>";
                          }
                          else {
                            $result_content = @mysqli_query($dbc_user, $query_des);
                            $num_of_fields = @mysqli_num_fields($result_content);
                            while ($row = @mysqli_fetch_array($result_content, MYSQLI_NUM)){
                                echo "<tr>";
                                for ($i = 0; $i < $num_of_fields; $i++){
                                    echo "<td>" . $row["$i"] . "</td>";
                                }
                              }
                          }
                        }


                         
                        ?>
                     </tbody>
                    </table>
                </div>
            </div>
        </div>
     </div>
<!--   </div> -->
</div>