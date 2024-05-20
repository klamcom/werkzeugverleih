<?php
require "inc/db-connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    var_dump($_POST);

    $marktID = $_POST['MarktID'];
    $markt = $_POST['markt'];

    
        $stmt = $pdo->prepare('UPDATE tblmarkt SET  MarktName = :markt WHERE MarktID = :marktID');
        $stmt->bindValue(':marktID', $marktID);
        $stmt->bindValue(':markt', $markt);

        $stmt->execute();

        header("Location: " . $_SERVER['HTTP_REFERER']);

}
?>