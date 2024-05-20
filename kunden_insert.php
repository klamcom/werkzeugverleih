<?php
require_once __DIR__ . '/inc/db-connect.php';
require_once __DIR__ . '/inc/functions.php';


if (!empty($_POST)) {

    $anrede = '';
    if (isset($_POST['anrede'])) {
        $anrede = (int) $_POST['anrede'];
    }

    $titel = '';
    if (isset($_POST['titel'])) {
        $titel = (int) $_POST['titel'];
    }

    $vorname = '';
    if (isset($_POST['vorname'])) {
        $vorname = (string) $_POST['vorname'];
    }

    $nachname = '';
    if (isset($_POST['nachname'])) {
        $nachname = (string) $_POST['nachname'];
    }

    $geschlecht = '';
    if (isset($_POST['geschlecht'])) {
        $geschlecht = (int) $_POST['geschlecht'];
    }

    $strasse = '';
    if (isset($_POST['strasse'])) {
        $strasse = (string) $_POST['strasse'];
    }

    $plz = '';
    if (isset($_POST['plz'])) {
        $plz = (string) $_POST['plz'];
    }

    $ort = '';
    if (isset($_POST['ort'])) {
        $ort = (string) $_POST['ort'];
    }

    $telefon = '';  
    if (isset($_POST['telnr'])) {
        $telefon = (string) $_POST['telnr'];
    }


    if (!empty($anrede) && !empty($titel) && !empty($vorname) && !empty($nachname) && !empty($geschlecht) && !empty($strasse) && !empty($plz) && !empty($ort) && !empty($telefon)) {
        
            $stmt = $pdo->prepare('INSERT INTO tblkunden (fkAnrede, fkTitel, Vorname, Nachname, fkGeschlecht, Strasse, PLZ, Ort, Telnr) 
            VALUES (:anrede, :titel, :vorname, :nachname, :geschlecht, :strasse, :plz, :ort, :telefon)');
    
            $stmt->bindValue('anrede', $anrede);
            $stmt->bindValue('titel', $titel);
            $stmt->bindValue('vorname', $vorname);
            $stmt->bindValue('nachname', $nachname);
            $stmt->bindValue('geschlecht', $geschlecht);
            $stmt->bindValue('strasse', $strasse);
            $stmt->bindValue('plz', $plz);
            $stmt->bindValue('ort', $ort);
            $stmt->bindValue('telefon', $telefon);
            $stmt->execute();
    
        }
      
        header("Location: " . $_SERVER['HTTP_REFERER']);


    }