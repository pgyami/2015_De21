<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<?php $dbc = mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);?>


<div class="panel panel-success">
  <?php echo '<div class="panel-heading">Create Table in database '.$_GET['selecteddatabase'].'</div>';?>
  
  <div class="panel-body">
    <form method="POST">
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

      <table class="table table-striped table-condensed table-hover">
        <thead>
          <tr>
            <th>Column name</th>
            <th>Type</th>
            <th>Length</th>
            <th>NULL</th>
            <th>Index</th>
            <th>A_I</th>
          </tr>
        </thead>
        <tbody  class="input_fields_wrap">
          <?php
          for ($i=0; $i < 1; $i++) { 
            echo '<tr>
            <td>
            <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
            <input type="text" class="form-control" placeholder="Column name" aria-describedby="basic-addon1" name="column_name[]">
            </div>
            </td>
            <td>
            <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
            <select class="form-control" name="data_type[]">
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
            <input type="text" class="form-control" placeholder="Length" aria-describedby="basic-addon1" name="data_size[]">
            </div>
            </td>
            <td><input type="checkbox" name="null"></td>
            <td>
            <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span>
            <select class="form-control" name="index[]">
            <option value="null"></option>
            <option value="unique">UNIQUE</option>
            <option value="primary">PRIMARY</option>
            </select>
            </div>
            </td>
            <td><input type="checkbox" name="ai"></td>
            </tr>';
          }

          ?>


        </tbody>
      </table>

      <br />

<!-- <div class="input_fields_wrap">
</div> -->
<button id='add_field_button' class='btn btn-info submit' value="Add more fields">Add more fields</button>
<button id='remove_field_button' class='btn btn-danger submit' value="Add more fields">Remove field</button><br />
<br />
</form>
<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $("#add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
      e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<tr><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><input type="text" class="form-control" placeholder="Column name" aria-describedby="basic-addon1" name="column_name[]"></div></td><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><select class="form-control" name="data_type[]"><option value="null"></option><option value="int">INT</option><option value="varchar">VARCHAR</option><option value="text">TEXT</option><option value="date">DATE</option><option value="char">CHAR</option><option value="float">FLOAT</option><option value="double">DOUBLE</option><option value="real">REAL</option><option value="boolean">BOOLEAN</option><option value="blob">BLOB</option></select></div></td><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><input type="text" class="form-control" placeholder="Length" aria-describedby="basic-addon1" name="data_size[]"></div></td><td><input type="checkbox" name="null"></td><td><div class="input-group"><span class="input-group-addon"><i class="fa fa-fw fa-edit"></i></span><select class="form-control" name="index[]"><option value="null"></option><option value="unique">UNIQUE</option><option value="primary">PRIMARY</option></select></div></td><td><input type="checkbox" name="ai"></td></tr>'); //add input box
          }
        });

    $(wrapper).on("click",".remove_field_button", function(e){ //user click on remove text
      e.preventDefault(); $(this).parent('tr').remove(); x--;
    })
  });
</script>
<?php
if(!empty($_POST["add_table"]) && !empty($_POST["table_name"])){
  mysqli_select_db($dbc, $_GET['selecteddatabase']);
  $table_name = $_POST["table_name"];
  $column_name = $_POST['column_name'];
  $data_type = $_POST['data_type'];
  $data_size = $_POST["data_size"];
  $count1 = count($_POST["column_name"]);
  $count2 = count($_POST["data_type"]);
  $count3 = count($_POST["data_size"]);
  $query = "CREATE TABLE $table_name (";
    if ($count1 == $count2 && $count2 == $count3){
      $i = 0;
      $count = $count1 - 1;
      for (; $i < $count; $i++){
        $query = $query . $column_name[$i] . " " . $data_type[$i] . "(" . $data_size[$i] ."),"; 
      }
      $query = $query . $column_name[$i] . " " . $data_type[$i] . "(" . $data_size[$i] .")"; 
    }
    $query = $query . ")";
$result = mysqli_query($dbc, $query);
if ($result)
  echo "<script>addAlert(\"success\",\"Create table successfully\");</script>";
else echo "<script>addAlert(\"success\",\"Create table failed\");</script>";
}
echo '<a href="index.php?action=manager_db&selecteddatabase='.$_GET['selecteddatabase'].'">Back to manager page</a>';
?>

</div>
</div>