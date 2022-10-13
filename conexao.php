<?php

$dsn = "mysql:dbname=controle_admissao;host=127.0.0.1";
$dbuser = "root";
$dbpass = "";
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);

    try {
        $db = new PDO($dsn, $dbuser, $dbpass, $options);
    } catch (PDOException $e) {
        echo "Falhou: " . $e->getMessage();
    }

?>