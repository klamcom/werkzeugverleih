<?php
require "inc/db-connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $verleihID = $_POST['verleihID'];
    $kundenID = $_POST['kundenID'];
    $werkzeugID = $_POST['werkzeugID'];
    $start = $_POST['start'];
    $ende = null;
    $marktID_Ausleihe = $_POST['marktID_Ausleihe'];
    $marktID_Rueckgabe = null;


    
        $stmt = $pdo->prepare('UPDATE tblVerleih SET fkKundenID = :kundenID, fkWerkzeugID = :werkzeugID, Start = :start, Ende = :ende, fkMarktID_Ausleihe = :marktID_Ausleihe, fkMarktID_Rueckgabe =:marktID_Rueckgabe WHERE VerleihID = :verleihID');

        $stmt->bindValue(':kundenID', $kundenID);
        $stmt->bindValue(':werkzeugID', $werkzeugID);
        $stmt->bindValue(':start', $start);
        $stmt->bindValue(':ende', $ende);
        $stmt->bindValue(':marktID_Ausleihe', $marktID_Ausleihe);
        $stmt->bindValue(':marktID_Rueckgabe', $marktID_Rueckgabe);
        $stmt->bindValue(':verleihID', $verleihID);
        
        $stmt->execute();

        header("Location: " . $_SERVER['HTTP_REFERER']);

}
?>

