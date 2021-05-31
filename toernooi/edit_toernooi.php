<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// hiermee include je de database
include '../database.php';
require_once('../header.php');
// dit start een nieuwe database connectie
$db = new database();

if(isset($_GET['toernooi_toernooiID'])){
    $db = new database();
    $toernooi = $db->select("SELECT * FROM toernooi WHERE toernooiID = :toernooiID", ['toernooiID'=>$_GET['toernooi_toernooiID']]);
    //print_r($artikel); // uitkomst in browser: Array ( [0] => Array ( [id] => 5 [artikel] => bloesem [prijs] => 5.95 ) )
}
    
// if(isset($_POST['submit'])){
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sql = "UPDATE toernooi SET toernooi=:toernooi WHERE toernooiID=:toernooiID";

    $placeholders = [
        'toernooi'=>$_POST['toernooi'],
        'toernooiID'=>$_POST['toernooiID']
    ];

    
    $db->update_or_delete($sql, $placeholders, 'toernooi.php');

}
?>

<div class="container">
    <form action="edit_toernooi.php" method="POST">
        <div class="form-group">
            <input type="hidden" name="toernooiID" value="<?php echo isset($_GET['toernooi_toernooiID']) ? $_GET['toernooi_toernooiID'] : '' ?>">
            <label for="toernooi">toernooi</label>
            <input type="text" class="form-control" name="toernooi" placeholder="toernooi" value="<?php echo isset($toernooi) ? $toernooi[0]['toernooi'] : ''?>">
            <br>
            <input type="submit" class="btn btn-lg btn-success btn-block" value="Edit">
        </div>
    </form>
</div>  
</body>
</html>