<?php
// this inserts the header
    require_once('../header.php');

// hiermee include je de database
    include "../database.php";

// dit start een nieuwe database connectie
$db = new database();
$speler = $db->select("SELECT spelerID, CONCAT  (voornaam, ' ',tussenvoegsel, ' ',achternaam) AS naam FROM speler WHERE neemtdeel = 1", []);

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $spelerID = $_POST['spelerID'];
    $id = (int)substr($spelerID, 0, 1);
    $sql = "SELECT ronde, toernooi.toernooi, 
    CONCAT (speler.voornaam, ' ',speler.tussenvoegsel, ' ',speler.achternaam) AS naam
    FROM wedstrijd 
    INNER JOIN speler
    ON wedstrijd.speler1ID = speler.spelerID
    INNER JOIN toernooi
    ON wedstrijd.toernooiID = toernooi.toernooiID 
    WHERE spelerID = :id";
    $wedstrijd = $db->select($sql, ['id'=>$id]); //[[id=>1....],[id->2....],[id=>3...]]
    $columns = array_keys($wedstrijd[0]);
    $row_data = array_values($wedstrijd);

}
?>
<body>
<div class="containter-fluid"><br>
    <div class="row ruim">
        <div class="col-2 ruimte"></div>

        <div class="col-3">
            <button type="button" class="btn btn-primary btn-lg btn btn-light"><a href="../index.php">terug</a></button>
            <br>
            <br>
            <button type="button" class="btn btn-primary btn-lg btn btn-light"><a href="wedstrijd_plannen.php">Wedstrijd Plannen</a></button>
        </div>
 

        <div class="col-2">
        <form class="form-signin" action="" method="post">
        <label for="spelers">spelers</label>
            <select name="spelerID" class="form-control form-control-lg">
                <?php foreach ($speler as $speler): ?>
                    <option name="<?php echo $speler["spelerID"]?>" value="<?php echo $speler["spelerID"]?>"><?=$speler["naam"]?></option>
                <?php endforeach ?>
            </select>
            <br>
            <input type="submit" name="submit" class="btn btn-lg btn-light btn-block" value="submit">
            <br>
        </form>
        </div>

        <div class="container spacing" >
            <table class="table table-hover">
                <tr>
                    <?php
                        if(isset($columns) && !empty($columns)){
                        foreach($columns as $column){ ?>
                            <th><strong><?php echo $column; ?></strong></th>
                    <?php    }

                    ?>
                </tr>

                <?php
                    foreach($row_data as $rows){ ?>
                    <tr>
                    <?php
                    foreach($rows as $data){
                        echo "<td> $data </td>";
                    }
                    }
                    ?>
            <?php } ?>
                    </tr>
            </table>
        </div>
    </div>
</div>
</body>

