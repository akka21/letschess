<?php
//index.php

// Hiermee include je de database class
include "../database.php";
require_once('../header.php');  

// dit start nieuwe database connectie
$db = new database();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>overzicht speler</title>
</head>
<body>

<?php
    $speler = $db->select("SELECT * FROM speler", []);
    // print_r($speler);

    $columns = array_keys($speler[0]);
    $row_data = array_values($speler);
    
?>
<div class="container">
    <div class="row">
        <div class="col-2">
            <button type="button" class="btn btn-primary btn-lg btn btn-light"><a href="../index.php">terug</a></button>
            <button type="button" class="btn btn-primary btn-lg btn btn-light"><a href="speler_toevoegen.php">speler toevoegen</a></button>
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
                            <a type="button" class="btn btn-success" href="edit_speler.php?speler_spelerID=<?php echo $rows['spelerID']?>"><i class="fa fa-pencil"></i> Edit</a>
                        </td>
                        <td>
                            <a type="button" class="btn btn btn-danger" href="delete_speler.php?speler_spelerID=<?php echo $rows['spelerID']?>"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                    </tr>

            </table>
        </div>
</div>

    
</body>
</html>
