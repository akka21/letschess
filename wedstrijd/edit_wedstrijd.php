<!DOCTYPE html>
<html lang="en">
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
<body>
<?php
include '../database.php';

$db = new database();

if(isset($_GET['wedstrijd_wedstrijdID'])){
    $db = new database();
    $wedstrijd = $db->select("SELECT ronde, speler1ID, speler2ID, punten1, punten2, toernooiID, winnaarID, wedstrijd.wedstrijdID, wedstrijd.ronde, 
    CONCAT(speler.voornaam, ' ', speler.tussenvoegsel, ' ', speler.achternaam) as speler1,
    CONCAT(speler1.voornaam, ' ', speler1.tussenvoegsel, ' ', speler1.achternaam) as speler2,
    wedstrijd.punten1,
    wedstrijd.punten2,
    wedstrijd.winnaarID
    FROM wedstrijd
    INNER JOIN speler speler
    ON speler.spelerID = wedstrijd.speler1ID
    INNER JOIN speler speler1
    ON speler1.spelerID = wedstrijd.speler2ID
    WHERE wedstrijdID = :wedstrijdID", ['wedstrijdID'=>$_GET['wedstrijd_wedstrijdID']]);
    //print_r($artikel); // uitkomst in browser: Array ( [0] => Array ( [id] => 5 [artikel] => bloesem [prijs] => 5.95 ) )
}
    
// if(isset($_POST['submit'])){
if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $wid = NULL;

        // bereken winnaarID op basis van ingevoerde punten
        // gelijkspel
        if($_POST['punten1'] == $_POST['punten2']){
            $wid = NULL;
        }

        if($_POST['punten1'] > $_POST['punten2']){
            // winnaarid
            $wid = $_POST['speler1ID'];
        }else{
            // speler 2 heeft hoogst aantal punten
            $wid = $_POST['speler2ID'];
        }

        $statement = "UPDATE wedstrijd SET punten1=:p1, punten2=:p2, winnaarID=:wid WHERE wedstrijdID=:wedstrijdID";
        $named_placeholder = [
            'p1'=>$_POST['punten1'],
            'p2'=>$_POST['punten2'],
            'wid'=>$wid,
            'wedstrijdID'=>$_POST['wedstrijdID']
        ]; 

    $db->update_or_delete($statement, $named_placeholder);

    // zorg ervoor dat de deelname status van de speler updated wordt
    //$sql = "UPDATE speler SET neemtdeel=0 WHERE spelerID IN (:speler1ID, :speler2ID)";

        // als we elimineren: alleen winnaarID (spelerID) op neemtdeel = 0 zetten:
        $sql = "UPDATE speler SET neemtdeel=0 WHERE spelerID=:wid";

        $placeholders = [
            'wid'=>$wid
            
        ];
    
    // $placeholders = [
    //     'speler1ID'=>$_POST['speler1ID'], 
    //     'speler2ID'=>$_POST['speler2ID']
    // ];

    // print_r($_POST);
    $db->update_or_delete($sql, $placeholders, 'uitslagen.php');
}
?>

<div class="container">
    <br><br><br>
    <form action="edit_wedstrijd.php" method="POST">
        <div class="form-group">
            <input type="hidden" name="wedstrijdID" value="<?php echo isset($_GET['wedstrijd_wedstrijdID']) ? $_GET['wedstrijd_wedstrijdID'] : '' ?>">
            <label for="ronde">Ronde</label>
            <input type="text" disabled="true" class="form-control" name="ronde" placeholder="ronde" value="<?php echo isset($wedstrijd) ? $wedstrijd[0]['ronde'] : ''?>">
            <br>

            
            <label for="speler1ID">Speler 1</label>
                <select name="speler1ID" class="form-control form-control-lg">
                <option value="<?= $wedstrijd[0]['speler1ID']?>"><?= $wedstrijd[0]['speler1']?></option>
            </select>

            <label for="punten1ID">Punten1</label>
            <input type="text" class="form-control" name="punten1" placeholder="punten1" value="<?php echo isset($wedstrijd) ? $wedstrijd[0]['punten1'] : ''?>">
            <br>

            <label for="speler2ID">Speler 2</label>
                <select name="speler2ID" class="form-control form-control-lg">
                <option value="<?= $wedstrijd[0]['speler2ID']?>"><?= $wedstrijd[0]['speler2']?></option>
            </select>

            <label for="punten2">Punten2</label>
            <input type="text" class="form-control" name="punten2" placeholder="punten2" value="<?php echo isset($wedstrijd) ? $wedstrijd[0]['punten2'] : ''?>">
            <br>
            
            <input type="submit" class="btn btn-lg btn-success btn-block" value="Edit">
        </div>
    </form>
</div>  
</body>
</html>