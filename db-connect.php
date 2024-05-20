<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=dbwerkzeugverleih1', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
catch(PDOException $e) {
    echo 'Probleme mit der Datenbankverbindung...';
    die();
}

