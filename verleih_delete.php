<?php
require 'db_connect.php'; 

$verleihId = $_POST['verleihId'];

if ($verleihId) {
    $stmt = $pdo->prepare("DELETE FROM tblverleih WHERE VerleihID = :verleihId");
    $stmt->execute(['verleihId' => $verleihId]);

    if ($stmt->rowCount()) {
        echo "Verleih erfolgreich gelöscht.";
    } else {
        echo "Fehler beim Löschen des Verleihs.";
    }
} else {
    echo "Keine Verleih-ID übergeben.";
}
?>