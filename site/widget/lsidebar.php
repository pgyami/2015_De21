<?php 
global $result_lsb;
global $type;
global $result_content;
global $selecteddatabase;
global $selectedtable;
global $item_name_lsb;
while ($row = @mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $dbname = $row['SCHEMA_NAME'];}?>
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
    <li class="active"><a href="#">List of <?php echo $item_name_lsb; ?> <span class="sr-only">(current)</span></a></li>
   
   <?php 

    if ($type == 1 || $type == 2) {
      # code...
      while ($row = @mysqli_fetch_array($result_lsb, MYSQLI_ASSOC)){
        $dbname = $row['SCHEMA_NAME'];
        echo "<li><a href='index.php?action=manager_db&selecteddatabase=$dbname'>".$dbname."</a></li>";
      }

    }
    elseif ($type == 3) {
      # code...
      while ($row = @mysqli_fetch_array($result_lsb, MYSQLI_ASSOC)){
        $tablename = $row["Tables_in_$selecteddatabase"];
        echo "<li><a href='index.php?action=manager_db&selecteddatabase=$selecteddatabase&selectedtable=$tablename'>".$tablename."</a></li>";
      }
    }
    
            ?>
  </ul>
</div>
