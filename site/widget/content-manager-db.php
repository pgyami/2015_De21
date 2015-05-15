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
        //
   
        
        
        
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
                        //incase user want to delete a row
                        if (!empty($_POST['query_delete'])){
                            $delete_criteria = $_POST['query_delete'];
                         
                            $delete_query = "DELETE FROM $selecteddatabase.$selectedtable WHERE $delete_criteria";
                            $result_des = @mysqli_query($dbc_user, $delete_query);
                            // Thien Son xu ly exception cho nay
                           // $error = mysqli_error($dbc_user);
                          //  echo "<script>addAlert(\"danger\",\"".$delete_query."\");</script>";
                           // echo "<script>addAlert(\"danger\",\"".$error."\");</script>";
                        //$query_content = "$query_content WHERE $filter_criteria";
                //echo $query_content;           
        }
                        
                        
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
                            
                            //Filter

                            $query_filter = "DESC $selecteddatabase.$selectedtable";                
                            $result_filter = @mysqli_query($dbc_user, $query_filter);
                          //  echo mysqli_error($dbc);
                            echo "<tr id =\"filter_row\">";
                           // mysqli_data_seek($result_filter,0);
                            while ($rows_filter = @mysqli_fetch_array($result_filter, MYSQLI_ASSOC)){
                              //  $row_filter = $rows_filter['Field'];

                               // echo "<td>" . "<input type=\"input\"  class=\"form-control\" placeholder=\"$row_filter\" id=\"row_filter_$count5\"  name='$row_filter'>" . "</td>";
                                echo '<td><input type="input" class="form-control" placeholder="'.$rows_filter['Field'].'"  name="'.$rows_filter['Field'].'"></td>';
                    
                            }
                    
                            echo "<form method='POST'>";
                            echo "<td class='text-left'><button type='submit' class='btn btn-success submit' id='ccc' name='filter_row' value=\"Filter\" onclick=\"getfilterQuery()\">Filter</button></td>";
                            echo "<td><input type='hidden' id='query_filter2' name='query_filter2' value=''></td>";
                            
                            
                            echo "</form>";
                            echo "</tr>";
                            //END - Filter
                            $count5 = 0;
                           
                            while ($row = @mysqli_fetch_array($result_content, MYSQLI_NUM)){
                                
                                $count5++;
                                 mysqli_data_seek($result_filter,0);
                                echo "<tr name = \"tr_delete_$count5\">";
                                for ($i = 0; $i < $num_of_fields; $i++){
                                    $rows_filter = @mysqli_fetch_array($result_filter, MYSQLI_ASSOC);
                                    echo "<td headers=\"".$rows_filter['Field']."\">" . $row["$i"] . "</td>";
                                }
                               /* $num1 = $num_of_fields - 1;*/
                               echo "<form method='POST'>";
                               echo "<td><input type='hidden' id='query_delete' name='query_delete' value=''></td>";
                               echo "<td name = \"td_delete_$count5\" class='text-left'><button type='submit' id=\"delete_button_$count5\" name='delete_button'  class='btn btn-danger submit' value=\"Delete\" onclick=\"deleteQuery(this.id)\">Delete</button></td>";
                               echo "</form>";
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
                   
                    filter_query = filter_query + filterrow_child2[0].name + " like \"%\"";
                }
                else
                {
                    filter_query = filter_query + filterrow_child2[0].name + " like " + " '" + filterrow_child2[0].value + "%'";
                }
            }
            else
            {
                if(filterrow_child2[0].value.length==0) 
                {
                    filter_query = filter_query + filterrow_child2[0].name + " like \"%\" AND ";
                }
                else
                {
                    filter_query = filter_query + filterrow_child2[0].name + " like " + " '" + filterrow_child2[0].value + "%'" + " AND ";
                }
            }
    
    }
   
    document.getElementById("query_filter2").value = filter_query;
}

function deleteQuery(clicked_id) {
   
    var deleterow = document.getElementById(clicked_id);
    
    var c = deleterow.parentNode.parentNode;

    alert(c.nodeName);
    
    var content = c.childNodes;
    
    var name_ = "";
    
    for(i = 0; i < content.length - 3; i++)
    {   
        var content_i = content[i];
        if(i == content.length - 4)
        name_ = name_ + content_i.headers + " = " + "'" + content_i.innerHTML +"'";
        else
         name_ = name_ + content_i.headers + " = " + "'" + content_i.innerHTML +"'" + " AND ";
         
    }
 //  alert(name_);
    c.querySelector("#query_delete").value = name_;
    alert(name_);
}
</script>