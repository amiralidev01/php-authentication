<?php

require 'config.php';
require 'constants.php';


# connect to the db
try {

    $pdo = new PDO("mysql:host=$db_config->host;dbname=$db_config->dbname;charset=$db_config->charset;", $db_config->user, $db_config->password);
} catch (PDOException $e) {
    die("Connection Failed :" . $e->getMessage());
}

# connect to the database successfully
echo "ok";
