<?php
require_once __DIR__ . '/inc/db-connect.php';
require_once __DIR__ . '/inc/functions.php';


if (!empty($_POST)) {

    $werkzeug = '';
    if (isset($_POST['werkzeug'])) {
        $werkzeug = (string) $_POST['werkzeug'];
    }


    if (!empty($werkzeug)) {
        
            $stmt = $pdo->prepare('INSERT INTO tblwerkzeuge (WerkzeugBezeichnung) 
            VALUES (:werkzeug)');
    
            $stmt->bindValue('werkzeug', $werkzeug);
            $stmt->execute();
    
        }
      
        header("Location: " . $_SERVER['HTTP_REFERER']);


    }