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
// Hiermee include je de database class
include '../database.php';
require_once('../header.php');
// dit start nieuwe database connectie
$db = new database();

if(isset($_GET['schaakvereniging_verenigingID'])){
    $db = new database();
    $schaakvereniging = $db->select("SELECT * FROM schaakvereniging WHERE verenigingID = :verenigingID", ['verenigingID'=>$_GET['schaakvereniging_verenigingID']]);
    //print_r($artikel); // uitkomst in browser: Array ( [0] => Array ( [id] => 5 [artikel] => bloesem [prijs] => 5.95 ) )
}
    
// if(isset($_POST['submit'])){
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sql = "UPDATE schaakvereniging SET naam=:naam, telefoonnummer=:telefoonnummer WHERE verenigingID=:verenigingID";

    $placeholders = [
        'naam'=>$_POST['naam'],
        'telefoonnummer'=>$_POST['telefoonnummer'],
        'verenigingID' =>$_POST['verenigingID']
    ];

    // Dit is een update of delete functie    
    $db->update_or_delete($sql, $placeholders, 'schaakvereniging.php');

}
?>
<!-- dit is een form met datatypes -->
<div class="container">
    <form action="edit_schaakvereniging.php" method="POST">
        <div class="form-group">
            <input type="hidden" name="verenigingID" value="<?php echo isset($_GET['schaakvereniging_verenigingID']) ? $_GET['schaakvereniging_verenigingID'] : '' ?>">
            <label for="naam">naam</label>
            <input type="text" class="form-control" name="naam" placeholder="naam" value="<?php echo isset($schaakvereniging) ? $schaakvereniging[0]['naam'] : ''?>">
            <br>
            <label for="telefoonnummer">telefoonnummer</label>
            <input type="text" class="form-control" name="telefoonnummer" placeholder="telefoonnummer" value="<?php echo isset($schaakvereniging) ? $schaakvereniging[0]['telefoonnummer'] : ''?>">
            <br>
            <input type="submit" class="btn btn-lg btn-success btn-block" value="Edit">
        </div>
    </form>
</div>  
</body>
</html>