<?php
require_once 'inc/db-connect.php';

if (isset($_POST['id'])) {
    $werkzeugId = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM tblwerkzeuge WHERE WerkzeugeID = :id");
    $stmt->bindValue(':id', $werkzeugId);
    $stmt->execute();

    echo "Werkzeug gelöscht";
}
?>