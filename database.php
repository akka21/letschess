<?php
// database.php
class database{
    private $servername;
    private $database;
    private $username;
    private $password;
    private $charset;
    private $conn;

function __construct() {
    $this->servername ='localhost';
    $this->database ='letschess';
    $this->username ='root';
    $this->password ='';
    $this->charset = 'utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES => false, 
     ];

    try{
        $dsn = "mysql:host=$this->servername;dbname=$this->database;charset=$this->charset";

        $this->conn = new PDO($dsn, $this->username, $this->password, $options);

    }   catch(\PDOException $e) {
            throw new \PDOException("Error  message is: ". $e->getMessage());
    }
        
}

//deze function insert data in de database
function wedstrijd_plannen($toernooiID, $speler1ID, $speler2ID, $ronde){

    try {
        $this->conn->beginTransaction();

        $sql = "INSERT INTO wedstrijd VALUES (:wedstrijdID, :ronde, :speler1ID, :speler2ID, :punten1, :punten2, :toernooiID, :winnaarID)";

        $stmt = $this->conn->prepare($sql); // checkt syntax van sql string en prepared op server

        // executes prepared statements, passes values to named placeholders from sql string on line 51
        $stmt->execute([
            'wedstrijdID'=>NULL,
            'ronde' => $ronde,
            'speler1ID'=> $speler1ID,
            'speler2ID' => $speler2ID,
            'punten1' =>NULL,
            'punten2' =>NULL,
            'toernooiID' => $toernooiID,
            'winnaarID' =>NULL
        ]);

        $this->conn->commit();
        header("Location: wedstrijd.php");
    } catch (\Exception $e) {
        $this->conn->rollBack();
        throw $e;
    }
}


//deze function insert data in de database
function speler_toevoegen($voornaam, $tussenvoegsel, $achternaam, $verenigingID){

    $sql = "INSERT INTO speler VALUES (:spelerID, :voornaam, :tussenvoegsel, :achternaam, :neemtdeel, :verenigingID)";

    $stmt = $this->conn->prepare($sql); // checkt syntax van sql string en prepared op server

    // executes prepared statements, passes values to named placeholders from sql string 
    $stmt->execute([
        'spelerID'=>NULL,
        'voornaam' => $voornaam,
        'tussenvoegsel' => $tussenvoegsel,
        'achternaam' => $achternaam,
        'neemtdeel' => 0,
        'verenigingID' =>$verenigingID

    ]);
    header('location: speler.php');
}

//deze function insert data in de database
function schaakvereniging_toevoegen($naam, $telefoonnummer){

    $sql = "INSERT INTO schaakvereniging VALUES (:verenigingID, :naam, :telefoonnummer)";

    $stmt = $this->conn->prepare($sql); // checkt syntax van sql string en prepared op server

    // executes prepared statements, passes values to named placeholders from sql string 
    $stmt->execute([
        'verenigingID'=>NULL,
        'naam' => $naam,
        'telefoonnummer' => $telefoonnummer,
    ]);
    header('location: schaakvereniging.php');
}

//deze function insert data in de database
function toernooi_toevoegen($toernooi){

    $sql = "INSERT INTO toernooi VALUES (:toernooiID, :toernooi)";

    $stmt = $this->conn->prepare($sql); // checkt syntax van sql string en prepared op server

    // executes prepared statements, passes values to named placeholders from sql string 
    $stmt->execute([
        'toernooiID'=>NULL,
        'toernooi' => $toernooi
    ]);
    header('location: toernooi.php');
}

//deze function selecteerd uit de database data om in je overzicht te platsen.
public function select($statment, $named_placeholder = []){

    $stmt = $this->conn->prepare($statment);
    $stmt->execute($named_placeholder);
    $result = $stmt->fetchALL(PDO::FETCH_ASSOC);

    // return alleen resultatenset als er data in zit.
    if(!empty($result)){
        return $result;
    }
    return;
}

//deze function update en delete op een sql statment dat je dan mee geeft.
public function update_or_delete($statement, $named_placeholder, $location = NULL){
        
    $stmt = $this->conn->prepare($statement);
    $stmt->execute($named_placeholder);

    if(!is_null($location)){
        header("location: $location");
        exit();
    }

    return;
    

}

public function insert($statement, $placeholders, $location=null){
    try {
        print_r($statement);
        print_r($placeholders);
        print_r($location);
        // start database transactie
        $this->db_connection->beginTransaction();

        // create PDOStatementObject and execute
        $stmt = $this->db_connection->prepare($statement);
        $stmt->execute($placeholders);

        // commit database changes
        $this->db_connection->commit();

        // check of er een redirect is
        if(!is_null($location)){
            header("location: $location.php");
        }else{
            // return van lastInsertId voor feature die niet geimplementeerd is.
            return $this->db_connection->lastInsertId();
        }
    }catch (Exception $e){
        // undo databasechanges in geval van error
        $this->db_connection->rollback();
        throw $e;
    }
}

}