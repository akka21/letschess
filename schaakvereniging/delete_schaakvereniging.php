<?php

// if(isset($_POST['submit'])){
if(isset($_GET['schaakvereniging_verenigingID'])){

    // Hiermee include je de database class
    include '../database.php';
    // dit start nieuwe database connectie
    $db = new database();

    // sql delete statement
    $sql = "DELETE FROM schaakvereniging WHERE verenigingID =:verenigingID ";

    $placeholders = [
        'verenigingID'=>$_GET['schaakvereniging_verenigingID']
    ];

    // Dit is een update of delete functie
    $db->update_or_delete($sql, $placeholders , 'schaakvereniging.php');
}

?>