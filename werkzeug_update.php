<?php
require "inc/db-connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    var_dump($_POST);

    $werkzeugID = $_POST['WerkzeugID'];
    $werkzeug = $_POST['werkzeug'];

    
        $stmt = $pdo->prepare('UPDATE tblwerkzeuge SET  WerkzeugBezeichnung = :werkzeug WHERE WerkzeugeID = :werkzeugID');
        $stmt->bindValue(':werkzeugID', $werkzeugID);
        $stmt->bindValue(':werkzeug', $werkzeug);

        $stmt->execute();

        header("Location: " . $_SERVER['HTTP_REFERER']);

}
?>