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

if(isset($_GET['speler_spelerID'])){
    $db = new database();
    $speler = $db->select("SELECT * FROM speler WHERE spelerID = :spelerID", ['spelerID'=>$_GET['speler_spelerID']]);
    //print_r($artikel); // uitkomst in browser: Array ( [0] => Array ( [id] => 5 [artikel] => bloesem [prijs] => 5.95 ) )
}
    
// if(isset($_POST['submit'])){
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sql = "UPDATE speler SET voornaam=:voornaam, tussenvoegsel=:tussenvoegsel, achternaam=:achternaam, neemtdeel=:neemtdeel WHERE spelerID=:spelerID";

    $placeholders = [
        'voornaam'=>$_POST['voornaam'],
        'tussenvoegsel'=>$_POST['tussenvoegsel'],
        'achternaam'=>$_POST['achternaam'],
        'neemtdeel'=>$_POST['neemtdeel'],
        'spelerID'=>$_POST['spelerID']
    ];

    // Dit is een update of delete functie    
    $db->update_or_delete($sql, $placeholders, 'speler.php');

}
?>
<!-- dit is een form met datatypes -->
<div class="container">
    <form action="edit_speler.php" method="POST">
        <div class="form-group">
            <input type="hidden" name="spelerID" value="<?php echo isset($_GET['speler_spelerID']) ? $_GET['speler_spelerID'] : '' ?>">
            <label for="voornaam">voornaam</label>
            <input type="text" class="form-control" name="voornaam" placeholder="voornaam" value="<?php echo isset($speler) ? $speler[0]['voornaam'] : ''?>">
            <br>
            <label for="tussenvoegsel">tussenvoegsel</label>
            <input type="text" class="form-control" name="tussenvoegsel" placeholder="tussenvoegsel" value="<?php echo isset($speler) ? $speler[0]['tussenvoegsel'] : ''?>">
            <br>
            <label for="achternaam">Achternaam</label>
            <input type="text" class="form-control" name="achternaam" placeholder="achternaam" value="<?php echo isset($speler) ? $speler[0]['achternaam'] : ''?>">
            <br>
            <label for="neemtdeel">neemtdeel</label>
            <input type="text" class="form-control" name="neemtdeel" placeholder="neemtdeel" value="<?php echo isset($speler) ? $speler[0]['neemtdeel'] : ''?>">
            <br>
            <input type="submit" class="btn btn-lg btn-success btn-block" value="Edit">
        </div>
    </form>
</div>  
</body>
</html>