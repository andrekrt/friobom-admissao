<?php

$dsn = "mysql:dbname=controle_admissao;host=127.0.0.1";
$dbuser = "root";
$dbpass = "";

    try {
        $db = new PDO($dsn, $dbuser, $dbpass);
    } catch (PDOException $e) {
        echo "Falhou: " . $e->getMessage();
    }

?>