<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<?php $dbc = @mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);?>


<div class="panel panel-success">
  <?php echo '<div class="panel-heading">Create Table in database '.$_GET['selecteddatabase'].'</div>';?>
  
  <div class="panel-body">
    <form method="POST">
      <input type="hidden" name="ai[0]" value="null"/>
      <input type="hidden" name="ai[1]" value="null"/>
      <input type="hidden" name="ai[2]" value="null"/>
      <input type="hidden" name="ai[3]" value="null"/>
      <input type="hidden" name="ai[4]" value="null"/>
      <input type="hidden" name="ai[5]" value="null"/>
      <input type="hidden" name="ai[6]" value="null"/>
      <input type="hidden" name="ai[7]" value="null"/>
      <input type="hidden" name="ai[8]" value="null"/>
      <input type="hidden" name="ai[9]" value="null"/>

      <input type="hidden" name="not_null[0]" value="null"/>
      <input type="hidden" name="not_null[1]" value="null"/>
      <input type="hidden" name="not_null[2]" value="null"/>
      <input type="hidden" name="not_null[3]" value="null"/>
      <input type="hidden" name="not_null[4]" value="null"/>
      <input type="hidden" name="not_null[5]" value="null"/>
      <input type="hidden" name="not_null[6]" value="null"/>
      <input type="hidden" name="not_null[7]" value="null"/>
      <input type="hidden" name="not_null[8]" value="null"/>
      <input type="hidden" name="not_null[9]" value="null"/>

      <div class='row'>
        <div class='col-sm-4'>
          <label class="col-sm-4 control-label">Table name</label>
          <div class="col-sm-8">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
              <input type="text" class="form-control" placeholder="Table name" aria-describedby="basic-addon1" name="table_name">
              <?if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array("password",$errors)) echo "Required" ?>
            </div>
          </div>                    
        </div>
        <button type='submit' name='add_table' class='btn btn-info submit' value="Add table">Add table</button><br />
      </div>
      <hr>
      <table class="table table-striped table-condensed table-hover">
        <thead>
          <tr>
            
            <th><center>Column name</center></th>
            <th><center>Type</center></th>
            <th><center>Length</center></th>
            <th style="width:100px;"><center>Not NULL</center></th>
            <th><center>Index</center></th>
            <th><center>A_I</center></th>
            <th></th>
          </tr>
        </thead>
        <tbody  class="input_fields_wrap">
          <tr>
            <td>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
                <input type="text" class="form-control" placeholder="Column name" aria-describedby="basic-addon1" name="column_name[]">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
                <select class="form-control" name="data_type[]" onchange="disableLength(this)">
                  <option value="null"></option>
                  <option value="int">INT</option>
                  <option value="varchar">VARCHAR</option>
                  <option value="text">TEXT</option>
                  <option value="date">DATE</option>
                  <option value="char">CHAR</option>
                  <option value="float">FLOAT</option>
                  <option value="double">DOUBLE</option>
                  <option value="real">REAL</option>
                  <option value="boolean">BOOLEAN</option>
                  <option value="blob">BLOB</option>
                </select>
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
                <input type="text" class="form-control" placeholder="Length" aria-describedby="basic-addon1" name="data_size[]"/>
              </div>
            </td>
            <td><center><input type="checkbox" name="not_null[0]" value="NOT NULL"/></center></td>
            <td>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
                <select class="form-control" name="index[]">
                  <option value="null"></option>
                  <option value="UNIQUE">UNIQUE</option>
                  <option value="PRIMARY KEY">PRIMARY</option>
                </select>
              </div>
            </td>
            <td><input type="checkbox" name="ai[0]" value="AUTO_INCREMENT"/></td>
            <td><button id="remove_field_button" class="btn btn-danger submit" >Remove field</button></td>          
          </tr>


        </tr>


      </tbody>
    </table>

    <br />

    <button id='add_field_button' class='btn btn-info submit' value="Add more field">Add more field</button><br />
    <br />
  </form>
  <script>
  function disableLength(a){
    type = a.options[a.selectedIndex].innerHTML;
            //alert(type);
            if (type == "DATE" | type == "TEXT" | type == "DOUBLE" | type == "REAL" | type == "BOOLEAN")
              a.parentNode.parentNode.nextElementSibling.children[0].children[0].nextElementSibling.readOnly = true;
            else
              a.parentNode.parentNode.nextElementSibling.children[0].children[0].nextElementSibling.readOnly = false;
          }
          $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $("#add_field_button"); //Add button ID
        
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
          e.preventDefault();
            if(x < max_fields){ //max input box allowed
                $(wrapper).append('<tr><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><input type="text" class="form-control" placeholder="Column name" aria-describedby="basic-addon1" name="column_name[]"></div></td><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><select class="form-control" name="data_type[]" onchange="disableLength(this)"><option value="null"></option><option value="int">INT</option><option value="varchar">VARCHAR</option><option value="text">TEXT</option><option value="date">DATE</option><option value="char">CHAR</option><option value="float">FLOAT</option><option value="double">DOUBLE</option><option value="real">REAL</option><option value="boolean">BOOLEAN</option><option value="blob">BLOB</option></select></div></td><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><input type="text" class="form-control" placeholder="Length" aria-describedby="basic-addon1" name="data_size[]"/></div></td><td><center><input type="checkbox" name="not_null[' + x + ']" value="NOT NULL"/></center></td><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><select class="form-control" name="index[]"><option value="null"></option><option value="UNIQUE">UNIQUE</option><option value="PRIMARY KEY">PRIMARY</option></select></div></td><td><input type="checkbox" name="ai[' + x + ']" value="AUTO_INCREMENT"/></td><td><button id="remove_field_button" class="btn btn-danger submit" >Remove field</button></td></tr>'); //add input box
                x++;
              }
            });

/*    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
      e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<tr><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><input type="text" class="form-control" placeholder="Column name" aria-describedby="basic-addon1" name="column_name[]"></div></td><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><select class="form-control" name="data_type[]"><option value="null"></option><option value="int">INT</option><option value="varchar">VARCHAR</option><option value="text">TEXT</option><option value="date">DATE</option><option value="char">CHAR</option><option value="float">FLOAT</option><option value="double">DOUBLE</option><option value="real">REAL</option><option value="boolean">BOOLEAN</option><option value="blob">BLOB</option></select></div></td><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><input type="text" class="form-control" placeholder="Length" aria-describedby="basic-addon1" name="data_size[]"></div></td><td><input type="checkbox" name="null"></td><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><select class="form-control" name="index[]"><option value="null"></option><option value="unique">UNIQUE</option><option value="primary">PRIMARY</option></select></div></td><td><input type="checkbox" name="ai"></td><td><button id="remove_field_button" class="btn btn-danger submit" >Remove field</button></td></tr>');
          }
        });*/

    $(wrapper).on("click","#remove_field_button", function(e){ //user click on remove text
      e.preventDefault(); 
      $(this).parent("td").parent("tr").remove(); x--;
    })
  });
</script>
<!-- =======
        $(wrapper).on("click",".remove_field_button", function(e){ //user click on remove text
          e.preventDefault(); 
          $(this).parent("tr").remove(); x--;
        })
      });
    </script>
    >>>>>>> origin/master -->
    <?php
    if (!empty($_POST["add_table"]) && empty($_POST["table_name"])) {
      # code...
      echo '<script>addAlert("danger","Table name is empty");</script>';
    }
    if(!empty($_POST["add_table"]) && !empty($_POST["table_name"])){
      mysqli_select_db($dbc, $_GET['selecteddatabase']);
      $table_name = $_POST["table_name"];
      $column_name = $_POST['column_name'];
      $data_type = $_POST['data_type'];
      $data_size = $_POST["data_size"];
      $ai = $_POST['ai'];
      $not_null = $_POST['not_null'];
      $index = $_POST['index'];
      $count1 = count($_POST["column_name"]);
      $count2 = count($_POST["data_type"]);
      $count3 = count($_POST["data_size"]);

      $query = "CREATE TABLE $table_name (";

      for ($i = 0; $i < $count1; $i++){
        $query = $query . $column_name[$i] . " " . $data_type[$i] . "(" . $data_size[$i] .") ". $ai[$i] . " " . $not_null[$i] . " " . $index[$i] . ","; 
      }
      $query = $query . ")";
      $query = str_replace(",)",")",$query);
      $query = str_replace("null","",$query);
      $query = str_replace("()","",$query);
      /*echo $query;*/
      $result = @mysqli_query($dbc, $query);
      $error =  @mysqli_error($dbc);
      
      if ($result)
        echo '<script>addAlert("success","Create table successfully");</script>';
      else echo '<script>addAlert("danger","'.$error.'");</script>';
      }
echo "<hr>";
echo '<a href="index.php?action=manager_db&selecteddatabase='.$_GET['selecteddatabase'].'"><button type="button" class="btn btn-default pull-right">Back to manager page</button></a>';
?>

</div>
</div>