<?php
require_once 'inc/db-connect.php';

if (isset($_POST['id'])) {
    $kundenId = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM tblkunden WHERE KundenID = :id");
    $stmt->bindValue(':id', $kundenId);
    $stmt->execute();

    echo "Kunde gelöscht";
}
?>