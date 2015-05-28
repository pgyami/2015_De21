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
  $show_table_structure_button = '<button type="button" class="btn btn-info submit" value="Show Structure" onclick="location.href=\'index.php?action=manager_db&selecteddatabase='.$selecteddatabase.'&selectedtable='.$selectedtable.'&showstructure=yes\';return false;">Show Structure</button>';
  $show_table_data_button = '<button type="button" class="btn btn-info submit" value="Show Data" onclick="location.href=\'index.php?action=manager_db&selecteddatabase='.$selecteddatabase.'&selectedtable='.$selectedtable.'\';return false;">Show Data</button>';
  $show_api_button = '<button type="button" class="btn btn-info submit" value="Show Data" onclick="showAPI()";return false;">Show API</button><br/><br/>'
?>
<form id = "clgt">
  </form>
<div class="col-sm-10">
  <script type="text/javascript">
   $(document).ready(function () {
      $('.editbtn').click(function (event) {
          var currentTD = $(this).parents('tr').find('td');
          if ($(this).html() == 'Edit') {                  
              $.each(currentTD, function () {
                  $(this).prop('contenteditable', true)
              });
          } else {
             $.each(currentTD, function () {
                  $(this).prop('contenteditable', false)
              });
          }

          
          if($(this).html() == 'Edit')
          {$(this).html( 'Save')}
        else
        {$("#clgt").submit();
      }

      });

  });
  </script>

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
              echo '&nbsp;';
              echo $show_api_button;
              
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
                            $result_delete = @mysqli_query($dbc_user, $delete_query);
                            $num_row_delete = @mysqli_affected_rows($dbc_user);
                            if ($num_row_delete == 1) {
                              echo '<script>addAlert("success","Delete '.$num_row_delete.' record successfully");</script>';
                            } 
                            elseif ($num_row_delete > 1)
                            {
                              echo '<script>addAlert("success","Delete '.$num_row_delete.' records successfully");</script>';}
                            else{
                              $error_delete =  mysqli_error($dbc_user);
                              echo '<script>addAlert("danger","Delete record failed");</script>';
                            }
                            
                            
/////////////////////////THIEN SON XU LY EXCEPTION CHO NAY NHA ////////////////////////////////////////////////
           
                        }
                        if (!empty($_POST['query_new'])){
                          $update_criteria = $_POST['query_old'];
                          $update_data = $_POST['query_new'];
                          $update_query = "UPDATE $selecteddatabase.$selectedtable SET $update_data WHERE $update_criteria";
                        
                          $result_update = @mysqli_query($dbc_user, $update_query);
                          
                          $num_row_update = @mysqli_affected_rows($dbc_user);
                            if ($num_row_update == 1) {
                              echo '<script>addAlert("success","Update '.$num_row_update.' record successfully");</script>';
                            } 
                            elseif ($num_row_update > 1)
                            {
                              echo '<script>addAlert("success","Update '.$num_row_update.' records successfully");</script>';}
                            else{
                              $error_update =  mysqli_error($dbc_user);
                              echo '<script>addAlert("danger","Update record failed");</script>';
                            }  
                            
/////////////////////////THIEN SON XU LY EXCEPTION CHO NAY NHA ////////////////////////////////////////////////
          
                        }
                        
                        # code...
                        $result_des = @mysqli_query($dbc_user, $query_des);
                        if (!$showstructure){
                          echo '<tr>';
                          
                          while ($row = @mysqli_fetch_array($result_des, MYSQLI_ASSOC))
                            echo '<th>' . $row['Field'] . '</th>';

                            echo '<th></th><th></th>';
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
                            /*while ($rows = @mysqli_fetch_array($result_des, @MYSQLI_ASSOC)){
                                $row = $rows['Field'];
                                if (empty($_POST[$row])){
                                    $add = false;
                                    break;
                                }
                            }*/
                            
                            
                            if ($add == true){
                                $result_des = @mysqli_query($dbc_user, $query_des);
                                $add = true;
                           
                               
                                $result_des = @mysqli_query($dbc_user, $query_des);
                                $field = '(';
                                $value = '(';
                                while ($rows = @mysqli_fetch_array($result_des, @MYSQLI_ASSOC)){
                                    $row = $rows['Field'];
                                    if(!empty($_POST[$row]))
                                    {
                                     $field=$field."".$row.",";
                                     $value=$value."'".$_POST[$row]."',";   
                                    }
                                    
                                }

                                
                               

                                 $query_insert = "INSERT INTO $selecteddatabase.$selectedtable".$field.") VALUES ".$value.")";
                                

                                $query_insert = str_replace(",)",")",$query_insert);
                                //echo $query_insert;
                                $result = @mysqli_query($dbc_user, $query_insert);
                                $error =  mysqli_error($dbc_user);
                                if (@mysqli_affected_rows($dbc_user) == 1){
                                   echo "<script>addAlert(\"success\",\"Create record successfully\");</script>";
                                } else {
                                    echo "<script>addAlert(\"danger\",\"".$error."\");</script>";
                                }
                            }
                        }
                        /*else echo '<script>addAlert("danger","Please fill information");</script>';*/

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
                                echo "<td name = \"td_edit_$count5\" class='text-left'><button type='submit' data-toggle=\"modal\" id=\"edit_button_$count5\" name='edit_button'  class='btn btn-info submit' value=\"Edit\" onclick=\"editQuery(this.id)\">Edit</button></td>";
                           
                               echo "<form method='POST'>";
                               echo "<td class='hidden'><input type='hidden' id='query_delete' name='query_delete' value=''></td>";
                               echo "<td name = \"td_delete_$count5\" class='text-left'><button type='submit' id=\"delete_button_$count5\" name='delete_button'  class='btn btn-danger submit' value=\"Delete\" onclick=\"deleteQuery(this.id)\">Delete</button></td>";
                               echo "</form>";
                               echo '</tr>';
                            }
                            
                            
   ?>
  
    <div id="myModal" class="modal fade" onload="getValue();">   
        <div class="modal-dialog">            
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Update</h4>
                </div>
                <div class="modal-body" id="model-body-content">
                    <p>Do you want to save changes you made to document before closing?</p>
                    <?php
                        $test = 1;
                        
                        mysqli_data_seek($result_filter,0);

                        while ($test <= $num_of_fields)
                        {
                            $i = $test - 1;
                            $rows_filter = @mysqli_fetch_array($result_filter, MYSQLI_ASSOC);

                    ?>
                            <div class="row">
                            <div class="col-sm-8" class="label_content">
                                <label class="col-sm-4 control-label" id="label_content_<?php echo $test; ?>"><?php echo $rows_filter['Field']; ?></label>
                            </div>
                            <div class="col-sm-4" class="input_content">
                                <input type="text" class="form-control" id="input_content_<?php echo $test; ?>" >
                            </div>
                            
                        </div>
                        </br>
                    <?php
                        
                            $test++;
                       } 
                    ?>
                    <input type='hidden' id='number_of_info' name='number_of_info' value=''>

                    <p class="text-warning"><small>If you don't save, your changes will be lost.</small></p>
                </div>
                <div class="modal-footer">
                     <form method='POST'>               
                    <input type='hidden' id='query_old' name='query_old' value=''>
                    <input type='hidden' id='query_new' name='query_new' value=''>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
                    <button id="save_edit_button" type='submit' type="button" class="btn btn-primary" onclick="getQuery()">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

                    <?php
                           
                            echo '<form method="POST">';
                            echo '<tr>';
                            $result_des = @mysqli_query($dbc_user, $query_des);
                            while ($row = @mysqli_fetch_array($result_des, MYSQLI_ASSOC)){
                              echo '<td><input type="input" class="form-control" placeholder="'.$row['Field'].'"  name="'.$row['Field'].'"></td>';
                            }

                            
                            echo "<td class='text-left'><button type='submit' class='btn btn-primary submit' name='add_row' value=\"Add\">Add</button></td>";
                            echo "<td></td>";
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

    var content = c.childNodes;
    
    var name_ = "";
    
    for(i = 0; i < content.length - 4; i++)
    {   
        var content_i = content[i];
        if(i == content.length - 5)
        name_ = name_ + content_i.headers + " = " + "'" + content_i.innerHTML +"'";
        else
         name_ = name_ + content_i.headers + " = " + "'" + content_i.innerHTML +"'" + " AND ";
         
    }
    c.querySelector("#query_delete").value = name_;
}

function editQuery(clicked_id){
    $(document).ready(function(){

		var editrow = document.getElementById(clicked_id);
        var c = editrow.parentNode.parentNode;
        
        var content = c.childNodes;
        var name_ = "";
        for(i = 0; i < content.length - 4; i++)
    {   
        var content_i = content[i];
        var number = i + 1;
        document.getElementById("input_content_"+number).value = content_i.innerHTML;
        
        if(i == content.length - 5)
        name_ = name_ + content_i.headers + " = " + "'" + content_i.innerHTML +"'";
        else
         name_ = name_ + content_i.headers + " = " + "'" + content_i.innerHTML +"'" + " AND ";
    }
        document.getElementById("query_old").value = name_;
       // alert(name_);
        document.getElementById("number_of_info").value = content.length-4;
  
        $("#myModal").modal('show');
        
         
});
}

function getQuery(){
    var numbers = document.getElementById("number_of_info").value;
    var content_length = parseInt(numbers);

    var name_ = "";
    
    for(i = 0; i < content_length; i++)
    {
        var j = i + 1;
        var titles = document.getElementById("label_content_"+j).innerHTML;
        var values = document.getElementById("input_content_"+j).value;
        if(i == content_length - 1)
        name_ = name_ + titles + " = " + "'" + values +"'";
        else
         name_ = name_ + titles + " = " + "'" + values +"'" + " , ";
    }

    document.getElementById("query_new").value = name_;
    
}

function showAPI(){
    $(document).ready(function(){
      $("#myAPI").modal('show');        
});
}
</script>
  <div id="myAPI" class="modal fade" onload="getValue();">   
      <div class="modal-dialog">            
          <div class="modal-content">
              <div class="modal-header" >
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">REST API</h4>
              </div>
              <div class="modal-body" id="model-body-content">
                  <p>We produce some APIs for user:</p>

                  <div class="row">             
                    <div class="col-sm-7" class="label_content">
                      <span class="label label-success">POST</span> /api/process_login.php
                      <br>
                      parameter: username, password, ajaxMode
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Login to system
                    </div>                  
                  </div>
                  <hr>
                  

                  <div class="row">             
                    <div class="col-sm-7" class="label_content">
                      <span class="label label-success">POST</span> /api/process_connection.php
                      <br>
                      parameter: id
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Select connection with given id
                    </div>                  
                  </div>
                  <hr>

                  <div class="row">             
                    <div class="col-sm-7" class="label_content">
                      <span class="label label-success">POST</span> /api/process_db.php
                      <br>
                      parameter: selecteddb
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Select database with given name
                    </div>                  
                  </div>
                  <hr>

                  <div class="row">             
                    <div class="col-sm-7" class="label_content">
                      <span class="label label-primary">GET</span> /api/query.php/{table}
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Get all rows from the table
                    </div>                  
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-7" class="label_content">
                         <span class="label label-primary">GET</span> /api/query.php/{table}/{id}
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Get a single row from the table with given id
                    </div>                  
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-7" class="label_content">
                        <span class="label label-primary">GET</span> /api/query.php/{table}/{column}/{content}
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Get all rows from the table where the column match content
                    </div>                  
                  </div>
                  <hr>

                  <div class="row">             
                    <div class="col-sm-7" class="label_content">
                      <span class="label label-primary">GET</span> /api/query.php/{table}/?limit={number}
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Get specified number of rows from the table
                    </div>                  
                  </div>
                  <hr>

                  <div class="row">             
                    <div class="col-sm-7" class="label_content">
                      <span class="label label-primary">GET</span> /api/query.php/{table}/?limit={number}&by={column}&order{type_filter}
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Get specified number of rows from the table with given column name and type of filter
                    </div>                  
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-7" class="label_content">
                         <span class="label label-danger">DELETE</span> /api/query.php/{table}/{id}
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Delete single row from the table with given id
                    </div>                  
                  </div>
                  <hr>

                  <div class="row">             
                    <div class="col-sm-7" class="label_content">
                      <span class="label label-success">POST</span> /api/query.php/{table}
                      <br>
                      parameter: fields in this table
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Create a new row in the table where the POST data corresponds to the table fields
                    </div>                  
                  </div>
                  <hr>

                  <div class="row">             
                    <div class="col-sm-7" class="label_content">
                      <span class="label label-warning">PUT</span> /api/query.php/{table}/{id}
                      <br>
                      parameter: fields in this table
                    </div>
                    <div class="col-sm-5" class="input_content">
                        Edit a row in the table where the POST data corresponds to the table fields with given id
                    </div>                  
                  </div>



                  <!-- <p class="text-warning"><small>If you don't save, your changes will be lost.</small></p> -->
              </div>
              <div class="modal-footer">
                   <form method='POST'>               
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              
                  </form>
              </div>
          </div>
      </div>
  </div>