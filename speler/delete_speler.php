<?php


if(isset($_GET['speler_spelerID'])){

    // Hiermee include je de database class
    include '../database.php';
    // dit start nieuwe database connectie
    $db = new database();

    // sql delete statement
    $sql = "DELETE FROM speler WHERE spelerID =:spelerID ";

    $placeholders = [
        'spelerID'=>$_GET['speler_spelerID']
    ];

    
    $db->update_or_delete($sql, $placeholders , 'speler.php');
}

?>