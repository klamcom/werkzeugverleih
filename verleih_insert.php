<?php
require_once __DIR__ . '/inc/db-connect.php';
require_once __DIR__ . '/inc/functions.php';


if (!empty($_POST)) {

    $kunde = '';
    if (isset($_POST['kunde'])) {
        $kunde = $_POST['kunde'];
    }

    $werkzeug = '';
    if (isset($_POST['werkzeug'])) {
        $werkzeug = $_POST['werkzeug'];
    }

    $start = '';
    if (isset($_POST['start'])) {
        $start = $_POST['start'];
    }

    $markt_ausleihe = '';
    if (isset($_POST['markt_ausleihe'])) {
        $markt_ausleihe = $_POST['markt_ausleihe'];
    }


    var_dump($_POST);

    if (!empty($kunde) && !empty($werkzeug) && !empty($start) && !empty($markt_ausleihe)) {
        
            $stmt = $pdo->prepare('INSERT INTO tblverleih (fkKundenID, fkWerkzeugID, fkMarktID_Ausleihe, Start, Ende) 
            VALUES (:fkkundenid, :fkwerkzeugid, :fkmarktid_ausleihe, :start, NULL)');

            $stmt->bindValue('fkkundenid', $kunde);
            $stmt->bindValue('fkwerkzeugid', $werkzeug);
            $stmt->bindValue('fkmarktid_ausleihe', $markt_ausleihe);
            $stmt->bindValue('start', $start);
                     
            $stmt->execute();
    
        }
      
        header("Location: " . $_SERVER['HTTP_REFERER']);


    }