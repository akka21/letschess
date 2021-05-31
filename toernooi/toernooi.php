<?php
//index.php

// hiermee include je de database
include "../database.php";
require_once('../header.php');  

// dit start een nieuwe database connectie
$db = new database();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>overzicht toernooi</title>
</head>
<body>

<?php
    $toernooi = $db->select("SELECT * FROM toernooi", []);
    // print_r($speler);

    $columns = array_keys($toernooi[0]);
    $row_data = array_values($toernooi);
    
?>
<div class="container"><br>
    <div class="row">
        <div class="col-2">
            <button type="button" class="btn btn-primary btn-lg btn btn-light"><a href="../index.php">terug</a></button>
            <br>
            <br>
            <button type="button" class="btn btn-primary btn-lg btn btn-light"><a href="toernooi_toevoegen.php">toernooi toevoegen</a></button>
        </div>
        <div class="col-1"></div>
        <div class="col-2">
            <table class="table table-hover">
                <tr>
                    <?php

                        foreach($columns as $column){ 
                            echo "<th><strong> $column </strong></th>";
                        }

                    ?>
                </tr>

                <?php
                    foreach($row_data as $rows){ ?>
                    <tr>
                    <?php
                    foreach($rows as $data){
                        echo "<td> $data </td>";
                    }
                    ?>
                        <td>
                            <a type="button" class="btn btn-success" href="edit_toernooi.php?toernooi_toernooiID=<?php echo $rows['toernooiID']?>"><i class="fa fa-pencil"></i> Edit</a>
                        </td>
                        <td>
                            <a type="button" class="btn btn btn-danger" href="delete_toernooi.php?toernooi_toernooiID=<?php echo $rows['toernooiID']?>"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                    </tr>

            </table>
        </div>
</div>

    
</body>
</html>
