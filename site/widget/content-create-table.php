<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<?php $dbc = mysqli_connect($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password']);?>
<form method="POST">
    <input type="submit" name="add_table" value="Add table"/><br />
    Table name: <input type="input" name="table_name"/><br />
    <div class="input_fields_wrap">
        <button class="add_field_button">Add More Fields</button><br />
        Ten cot<input type="text" name="column_name[]"/>
        Kieu <select name="data_type[]">
                <option value="int">INT</option>
                <option value="varchar">VARCHAR</option>
            </select>
        Kich thuoc<input type="text" name="data_size[]"/></div>
    </div>
</form>
<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div>Ten cot <input type="text" name="column_name[]"/><select name="data_type[]">Kieu<option value="int">INT</option><option value="varchar">VARCHAR</option></select><input type="text" name="data_size[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
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
}
?>
<a href="index.php?action=manager_db">Quay ve trang quan ly</a>