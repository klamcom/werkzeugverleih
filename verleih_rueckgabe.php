<?php
require "inc/db-connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ende = $_POST['ende'];
    $marktID_Rueckgabe = $_POST['marktID_Rueckgabe'];


    
        $stmt = $pdo->prepare('UPDATE tblVerleih Ende = :ende, fkMarktID_Rueckgabe =:marktID_Rueckgabe WHERE VerleihID = :verleihID');

        $stmt->bindValue(':ende', $ende);
        $stmt->bindValue(':marktID_Rueckgabe', $marktID_Rueckgabe);
        $stmt->bindValue(':verleihID', $verleihID);
        
        $stmt->execute();

        header("Location: " . $_SERVER['HTTP_REFERER']);

}
?>

