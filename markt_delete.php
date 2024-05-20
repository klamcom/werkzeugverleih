<?php
require_once 'inc/db-connect.php';

if (isset($_POST['id'])) {
    $marktId = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM tblmarkt WHERE MarktID = :id");
    $stmt->bindValue(':id', $marktId);
    $stmt->execute();

    echo "Markt gelöscht";
}
?>