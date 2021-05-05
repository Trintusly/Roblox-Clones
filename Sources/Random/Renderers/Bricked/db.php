<?php

// Initialize database connection

$dbUser = "bric_user";
$dbPass = "93LP5g@1xJH5";

try {
    $db = new PDO('mysql:host=45.148.164.7;dbname=bric_db', $dbUser, $dbPass);
    /*
    foreach($dbh->query('SELECT * from FOO') as $row) {
        print_r($row);
    }
    */
    //$db = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

// End database connection


// Remote db functions


// End remote db functions
?>
