<?php


if(isset($_GET['toernooi_toernooiID'])){

    // Hiermee include je de database class
    include '../database.php';
    $db = new database();

    $sql = "DELETE FROM toernooi WHERE toernooiID =:toernooiID ";

    $placeholders = [
        'toernooiID'=>$_GET['toernooi_toernooiID']
    ];

    // sql statements
    $db->update_or_delete($sql, $placeholders , 'toernooi.php');
}

?>