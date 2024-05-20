<?php
require "inc/db-connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $kundenID = $_POST['kundenID'];
    $anrede = $_POST['anrede'];
    $titel = $_POST['titel'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $geschlecht = $_POST['geschlecht'];
    $strasse = $_POST['strasse'];
    $plz = $_POST['plz'];
    $ort = $_POST['ort'];
    $telnr = $_POST['telnr'];


    
        $stmt = $pdo->prepare('UPDATE tblkunden SET fkAnrede = :anrede, fkTitel = :titel, Vorname = :vorname, Nachname = :nachname, fkGeschlecht = :geschlecht, Strasse = :strasse, PLZ = :plz, Ort = :ort, Telnr = :telnr WHERE KundenID = :kundenID');

        $stmt->bindValue(':kundenID', $kundenID);
        $stmt->bindValue(':anrede', $anrede);
        $stmt->bindValue(':titel', $titel);
        $stmt->bindValue(':vorname', $vorname);
        $stmt->bindValue(':nachname', $nachname);
        $stmt->bindValue(':geschlecht', $geschlecht);
        $stmt->bindValue(':strasse', $strasse);
        $stmt->bindValue(':plz', $plz);
        $stmt->bindValue(':ort', $ort);
        $stmt->bindValue(':telnr', $telnr);

        $stmt->execute();

        header("Location: " . $_SERVER['HTTP_REFERER']);

}
?>