<?php

include_once ('dbconfiguration.php');

try {
    $dsn = 'mysql:dbname=' . DB_DATABASE . ';host=' . DB_HOST . ';port=3306;';
    $db = new PDO($dsn, DB_USER, DB_PASSWORD);

    //CRUD operations shall be here

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>