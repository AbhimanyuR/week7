<?php

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//db connection class using singleton pattern
class dbConn{

    //variable to hold connection object.
    protected static $db;

    //private construct - class cannot be instatiated externally.
    private function __construct() {

        try {
            // assign PDO object to db variable
            self::$db = new PDO( 'mysql:host=sql2.njit.edu;dbname=paa36', 'paa36', 'ESYoCrmHd' );
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            echo "Connected successfully" ."<br>"."<br>";
        }
        catch (PDOException $e) {
            //Output error - would normally log this to error file rather than output to user.
            echo "Connection Error: " . $e->getMessage();
        }

    }

    // get connection function. Static method - accessible without instantiation
    public static function getConnection() {

        //Guarantees single instance, if no connection object exists then create one.
        if (!self::$db) {
            //new connection object.
            new dbConn();
        }

        //return connection.
        return self::$db;
    }
}
    $db = dbConn::getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $db->prepare('SELECT * FROM accounts WHERE ID<6');
    $statement->execute();
    $records=$statement->rowCount();
    echo "Total number of records = " .$records ."<br>"."<br>";
    $result = $statement->Fetch(PDO::FETCH_ASSOC);

    echo "<table border='1'>";
    echo "<tr>";
    //Gets the field names from the query
    foreach ($result as $names => $value) {
        echo "<th> $names</th>";
    }
    echo " </tr> ";

    $statement->execute();
//Gets the data from the query
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    foreach ($statement as $data) {
        echo " <tr> ";
        foreach ($data as $row => $value) {
            echo " <td>$value</td> ";
        }
        echo " </tr> ";
    }
    echo "</table> ";

?>