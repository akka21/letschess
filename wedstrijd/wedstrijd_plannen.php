<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  </head>
<?php
// hiermee include je de database
include "../database.php";


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    // dit start een nieuwe database connectie
    $database = new database();
    
    // zorg ervoor dat de deelname status van de speler updated wordt
    $sql = "UPDATE speler SET neemtDeel=1 WHERE spelerID IN (:speler1ID, :speler2ID)";
    $placeholders = [
        'speler1ID'=>$_POST['speler1ID'], 
        'speler2ID'=>$_POST['speler2ID']
    ];
    $database->update_or_delete($sql, $placeholders);

    

    $toernooiID = $_POST['toernooiID'];
    $speler1ID = $_POST['speler1ID'];
    $speler2ID = $_POST['speler2ID'];
    $ronde = $_POST['ronde'];

    $database->wedstrijd_plannen($toernooiID, $speler1ID, $speler2ID, $ronde);

    // print_r($_POST);
    $db->update_or_delete($sql, $placeholders, 'uitslagen.php');
}

?>
<body> 
<div class="none">
<?php
$database = new database();
$toernooi = $database->select("SELECT toernooiID, toernooi FROM toernooi", []);
$spelers = $database->select("SELECT spelerID, concat(voornaam, ' ',tussenvoegsel, ' ', achternaam) as naam FROM speler WHERE neemtDeel=false", []);
$speler1 = [];
$speler2 = [];


foreach($spelers as $key=>$speler){
    if($key % 2 == 0){
        array_push($speler2, $speler);
    }else{
        array_push($speler1, $speler);
    }
}
?>

</div>

<div class="container-fluid">
        <div class="row">
            <div class="col-7">
                <img class="img-fluid blur" style="float: left;" src="../images/Chess.jpg" alt="Chess">
            </div>

        <div class="col-3 border shadow p-3 mb-5 bg-white rounded registreer">
            <form class="form-signin" action="wedstrijd_plannen.php" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Wedstrijd Plannen</h1>

                <label for="toernooi">Toernooi</label>
                <select name="toernooiID" class="form-control form-control-lg">
                <?php foreach ($toernooi as $toernooi): ?>
                    <option value="<?=$toernooi["toernooiID"]?>"><?=$toernooi["toernooi"]?></option>
                <?php endforeach ?>
                </select>
                <br>


            <label for="ronde">Rondes</label>
            <select class="form-control form-control-lg" name="ronde">
                <option value="1">Ronde 1</option>
                <option value="2">Ronde 2</option>
                <option value="3">Ronde 3</option>
            </select><br>


                <label for="speler1">Speler 1</label>
                <select name="speler1ID" class="form-control form-control-lg">
                <?php foreach ($speler1 as $key=>$speler): ?>
                    <option value="<?=$speler["spelerID"]?>"><?=$speler["naam"]?></option>
                <?php endforeach ?>
                </select>
                <br>
                

                <label for="speler2">Speler 2</label>
                <select name="speler2ID" class="form-control form-control-lg">
                <?php foreach ($speler2 as $speler): ?>
                    <option value="<?=$speler["spelerID"]?>"><?=$speler["naam"]?></option>
                <?php endforeach ?>
                </select>
                <br>

                <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="submit"> 
                
            </form>
        </div>
    </div>
</div>  
</body>
