<?php
require_once __DIR__ . '/inc/db-connect.php';
require_once __DIR__ . '/inc/functions.php';


if (!empty($_POST)) {

    $markt = '';
    if (isset($_POST['markt'])) {
        $markt = (string) $_POST['markt'];
    }


    if (!empty($markt)) {
        
            $stmt = $pdo->prepare('INSERT INTO tblmarkt (MarktName) 
            VALUES (:markt)');
    
            $stmt->bindValue('markt', $markt);
            $stmt->execute();
    
        }
      
        header("Location: " . $_SERVER['HTTP_REFERER']);


    }