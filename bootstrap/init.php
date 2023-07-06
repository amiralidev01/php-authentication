<?php
session_start();
date_default_timezone_set('Asia/Tehran');

require 'vendor/autoload.php';
require 'config.php';
require 'constants.php';
require BASE_PATH . 'libs/helpers.php';
require BASE_PATH . 'libs/lib-auth.php';
require 'mail.php';

# connect to the db
try {

    $pdo = new PDO("mysql:host=$db_config->host;dbname=$db_config->dbname;charset=$db_config->charset;", $db_config->user, $db_config->password);
} catch (PDOException $e) {
    die("Connection Failed :" . $e->getMessage());
}

# connect to the database successfully
// echo "ok";
