
<?php // Werkzeug abrufen und anzeigen ?>

<?php
    $stmt_werkzeug = $pdo->prepare('SELECT * FROM tblwerkzeug ORDER BY WerkzeugeID ASC');
    $stmt_werkzeug->execute();
    $werkzeuge = $stmt_werkzeug->fetchAll(PDO::FETCH_ASSOC);

                        
?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Werkzeug Bezeichnung</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($werkzeuge AS $werkzeug): ?>    
        <tr>
            <td><?php echo $werkzeug['WerkzeugeID']; ?></td>
            <td><?php echo $werkzeug['WerkzeugBezeichnung']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>   

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#werkzeugModal">
Neues Werkzeug hinzufügen
</button>
