<?php
//index.php

// include the database class
include "../database.php";
require_once('../header.php');  

// dit start nieuwe database connectie
$db = new database(); 

$geenDataBeschikbaar = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>overzicht schaakvereniging</title>
</head>
<body>

<?php
    $schaakvereniging = $db->select("SELECT * FROM schaakvereniging", []);
    // print_r($schaakvereniging);

    $columns = array_keys($schaakvereniging[0]);
    $row_data = array_values($schaakvereniging);
    
    if(is_array($schaakvereniging) && !empty($schaakvereniging)){
        $geenDataBeschikbaar = false;
    }else if($geenDataBeschikbaar){ ?>
        <p class='no-data'>Geen schaakvereniging data beschikbaar</p>
    <?php } ?>

<div class="container"><br>
    <div class="row">
        <div class="col-3">
            <button type="button" class="btn btn-primary btn-lg btn btn-light"><a href="../index.php">terug</a></button>
            <br>
            <br>
            <button type="button" class="btn btn-primary btn-lg btn btn-light"><a href="schaakvereniging_toevoegen.php">schaakvereniging toevoegen</a></button>
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
                            <a type="button" class="btn btn-success" href="edit_schaakvereniging.php?schaakvereniging_verenigingID=<?php echo $rows['verenigingID']?>"><i class="fa fa-pencil"></i> Edit</a>
                        </td>
                        <td>
                            <a type="button" class="btn btn btn-danger" href="delete_schaakvereniging.php?schaakvereniging_verenigingID=<?php echo $rows['verenigingID']?>"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                    </tr>

            </table>
        </div>
</div>

    
</body>
</html>
