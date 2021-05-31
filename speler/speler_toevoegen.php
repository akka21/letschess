<?php
//index.php

// Hiermee include je de database class
include "../database.php";

require_once('../header.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $fields = ['voornaam', 'achternaam'];

    $error = false;
    // dit is een foreach check
    foreach($fields as $field){
        if(!isset($_POST[$field]) || empty($_POST[$field])){
         $error = true;
    }
}

if(!$error){
    // Sla posted form values in variables op
    $voornaam= $_POST['voornaam'];
    $tussenvoegsel= isset($_POST['tussenvoegsel']) ? $_POST['tussenvoegsel'] : '';
    $achternaam= $_POST['achternaam'];
    $verenigingID= $_POST['verenigingID'];


        
    $database = new database();
    // login functie
    $database->speler_toevoegen($voornaam, $tussenvoegsel, $achternaam, $verenigingID);
 }
}
$database = new database();
$vereniging = $database->select("SELECT verenigingID, naam FROM schaakvereniging", []);
?>

<body>
<div class="container-fluid"><br>
        <div class="row">
            <div class="col-7">
                <img class="img-fluid blur" style="float: left;" src="../images/Chess.jpg" alt="speler">
            </div>

        <div class="col-3 ruimte border shadow p-3 mb-5 bg-white rounded registreer">
        
            <form class="form-signin" action="speler_toevoegen.php" method="post">
            <h1 class="h3 mb-3 font-weight-normal">speler Toevoegen</h1>

                <label for="voornaam">voornaam</label>
                <input type="text" name="voornaam" class="form-control" required="">
                <br>

                <label for="tussenvoegsel">tussenvoegsel</label>
                <input type="text" name="tussenvoegsel" class="form-control">
                <br>

                <label for="achternaam">achternaam</label>
                <input type="text" name="achternaam" class="form-control" required="">
                <br>

                <label for="vereniging">vereniging</label>
                <select name="verenigingID" class="form-control form-control-lg">
                <?php foreach ($vereniging as $vereniging): ?>
                    <option value="<?=$vereniging["verenigingID"]?>"><?=$vereniging["naam"]?></option>
                <?php endforeach ?>
                </select>
                <br>

                <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="submit">
            </form>
            <br>
            <button type="button" class="btn btn-primary btn-lg btn btn-light"><a href="speler.php">terug</a></button>
        </div>
    </div>
</div>  
</body>
