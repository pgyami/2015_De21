<?php
  global $result_lsb;
  global $type;
  global $result_content;
  global $result_des;
  global $selecteddatabase;
  global $selectedtable;
  $create_database_button = '<button type="button" class="btn btn-info submit" value="Create Databases" onclick="location.href=\'index.php?action=create_database\';return false;">Create Databases</button><br/><br/>';
  $create_table_button = '<button type="button" class="btn btn-info submit" value="Create Table" onclick="location.href=\'index.php?action=create_table&selecteddatabase='.$selecteddatabase.'\';return false;">Create Table</button><br/><br/>';
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
            }
        ?>
        <div class="panel panel-info">
            <div class="panel-heading">
              <?php 
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
                      if ($type == 3) {
                        # code...
                        echo '<tr>';

                        while ($row = @mysqli_fetch_array($result_des, @MYSQLI_ASSOC))
                          echo '<th>' . $row['Field'] . '</th>';

                        echo '</tr>';
                      }
                      elseif ($type == 1) {
                        # code...
                        echo '<tr><th>Database name</th><td></td></tr>';
                      }
                      else echo '<tr><th>Table name</th><td></td></tr>';
                      ?>                                             
                     </thead>          
                     <tbody>
                        <?php
                        global $result_content;
                        global $type;
                        global $selecteddatabase;
                        global $selectedtable;
                        if ($type == 1) {
                            # code...
                          if (@mysqli_num_rows($result_content) != 0){ 
                            while ($row = @mysqli_fetch_array($result_content, @MYSQLI_ASSOC)){
                              $dbname = $row['SCHEMA_NAME'];
                              echo "<tr><td><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a></td>";
                              echo '<td class="text-left"><button type="button" class="btn btn-danger submit" value="Delete Database" onclick="location.href="index.php?action=delete_database&deletedatabase='.$dbname.'";return false;">Delete</button></td>';
                              echo "</tr>";
                            }
                          }
                          else echo "There is no database";
                        }
                        elseif ($type == 2) {
                            # code...
                          if (@mysqli_num_rows($result_content) != 0){ 
                             while ($row = @mysqli_fetch_array($result_content, @MYSQLI_ASSOC)){
                                $tablename = $row["Tables_in_$selecteddatabase"];
                                echo "<tr>";
                                echo "<td><a href='index.php?action=manager_db&selecteddatabase=$selecteddatabase&selectedtable=$tablename'>".$tablename."</a></td>";
                                echo '<td class="text-left"><button type="button" class="btn btn-danger submit" value="Delete Table" onclick="location.href="index.php?action=delete_table&selecteddatabase='.$selecteddatabase.'&deletetable='.$tablename.'";return false;">Delete</button></td>';
                                echo "</tr>";
                              }
                            }
                            else echo "This database have no table";
                        }
                        elseif ($type == 3) {
                          # code...
                          $num_of_fields = @mysqli_num_fields($result_content);
                          while ($row = @mysqli_fetch_array($result_content, @MYSQLI_NUM)){
                              echo "<tr>";
                              for ($i = 0; $i < $num_of_fields; $i++){
                                  echo "<td>" . $row["$i"] . "</td>";
                              }
                             /* $num1 = $num_of_fields - 1;*/
                             echo "<td class='text-left'><button type='submit' name='delete_button' class='btn btn-danger submit' value=\"Delete\">Delete</button></td>";
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