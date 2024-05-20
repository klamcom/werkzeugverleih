<?php require "inc/db-connect.php"; ?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Werkzeugverleih</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <style>
        body {
            width: 100%
        }
        .flex-container {
            display: flex;
            flex-wrap: wrap;
        }
        .flex-container > div {
            flex: 1;
        }
        .content {
            min-height: 400px
        }
        #asideLinks, #asideRechts {
            flex: 1;
        }
        #divContent1, #divContent2 ,#divContent3, #divContent4 {
            flex: 10;
        }

        @media (min-width: 600px) {
            body {
                width: 90%;
                margin: auto;
            }
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white p-3">
    </header>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="?section=kunden">Kunden</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?section=werkzeugausleihen">Werkzeug ausleihen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?section=werkzeuganlegen">Werkzeug</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?section=maerkte">Märkte</a>
            </li>
        </ul>
    </div>
    </nav>

    <div class="flex-container">
        <aside id="asideLinks" class="bg-light p-3">Aside 1</aside>

        <?php $section = isset($_GET['section']) ? $_GET['section'] : 'default'; ?>

            <div id="divContent1" class="content bg-white p-3" style="<?php echo $section == 'kunden' ? '' : 'display: none;'; ?>">

            <?php // Kundendaten abrufen und anzeigen ?>

                <?php
                    $stmt_kunden = $pdo->prepare('SELECT tblkunden.*, tblanrede.Anrede, tblanrede.AnredeID, tbltitel.TitelID, tbltitel.Titel, tblgeschlecht.GeschlechtID, tblgeschlecht.Geschlecht FROM tblkunden
                                                    LEFT JOIN tblanrede ON tblanrede.AnredeID = tblkunden.fkAnrede 
                                                    LEFT JOIN tbltitel ON tbltitel.TitelID = tblkunden.fkTitel
                                                    JOIN tblgeschlecht ON tblgeschlecht.GeschlechtID = tblkunden.fkGeschlecht
                                                    ORDER BY Nachname, Vorname ASC');
                    $stmt_kunden->execute();
                    $kunden = $stmt_kunden->fetchAll(PDO::FETCH_ASSOC);

                    $stmt_anrede = $pdo->prepare("SELECT AnredeID, Anrede FROM tblAnrede");
                    $stmt_anrede->execute();
                    $anreden = $stmt_anrede->fetchAll(PDO::FETCH_ASSOC);

                    $stmt_titel = $pdo->prepare("SELECT TitelID, Titel FROM tblTitel");
                    $stmt_titel->execute();
                    $titeln = $stmt_titel->fetchAll(PDO::FETCH_ASSOC);

                    $stmt_geschlecht = $pdo->prepare("SELECT GeschlechtID, Geschlecht FROM tblgeschlecht");
                    $stmt_geschlecht->execute();
                    $geschlechter = $stmt_geschlecht->fetchAll(PDO::FETCH_ASSOC);

                    
                ?>

                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Anrede</th>
                            <th>Titel</th>
                            <th>Vorname</th>
                            <th>Nachname</th>
                            <th>Geschl.</th>
                            <th>Straße</th>
                            <th>PLZ</th>
                            <th>Ort</th>
                            <th>Tel</th>
                            <th>Bearb.</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($kunden AS $kunde): ?>    
                        <tr>
                            <td><?php echo $kunde['KundenID']; ?></td>
                            <td><?php echo $kunde['Anrede']; ?></td>
                            <td><?php echo $kunde['Titel']; ?></td>
                            <td><?php echo $kunde['Vorname']; ?></td>
                            <td><?php echo $kunde['Nachname']; ?></td>
                            <td><?php echo $kunde['Geschlecht']; ?></td>
                            <td><?php echo $kunde['Strasse']; ?></td>
                            <td><?php echo $kunde['PLZ']; ?></td>
                            <td><?php echo $kunde['Ort']; ?></td>
                            <td><?php echo $kunde['Telnr']; ?></td>
                            <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bearbeitenKundenModal" onclick="ladenKundenDaten('<?= $kunde['KundenID'] ?>', '<?= $kunde['AnredeID'] ?>', '<?= $kunde['TitelID'] ?>', '<?= $kunde['Vorname'] ?>', '<?= $kunde['Nachname'] ?>', '<?= $kunde['GeschlechtID'] ?>', '<?= $kunde['Strasse'] ?>', '<?= $kunde['PLZ'] ?>', '<?= $kunde['Ort'] ?>', '<?= $kunde['Telnr'] ?>')">
                                Bearb.
                            </button>
                            <button onclick="openDeleteConfirmModal(<?php echo $kunde['KundenID']; ?>)" class="btn btn-danger">Löschen</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>   
                
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kundenModal">
                Neuen Kunden hinzufügen
                </button>
            </div>

            <div id="divContent2" class="content bg-white p-3" style="<?php echo $section == 'werkzeugausleihen' ? '' : 'display: none;'; ?>">

            <?php // Werkzeugausleihungen anlegen und anzeigen ?>

                <?php
                    $stmt_verleih = $pdo->prepare('SELECT tblverleih.*, tblkunden.*, tblwerkzeuge.*, tblmarktAusleihe.MarktID, tblmarktAusleihe.MarktName AS MarktAusleihe, tblmarktRueckgabe.MarktID, tblmarktRueckgabe.MarktName AS MarktRueckgabe
                                                    FROM tblverleih 
                                                    LEFT JOIN tblkunden ON tblkunden.KundenID = tblverleih.fkKundenID
                                                    LEFT JOIN tblwerkzeuge ON tblwerkzeuge.WerkzeugeID = tblverleih.fkWerkzeugID
                                                    LEFT JOIN tblmarkt AS tblmarktAusleihe ON tblmarktAusleihe.MarktID = tblverleih.fkMarktID_Ausleihe
                                                    LEFT JOIN tblmarkt AS tblmarktRueckgabe ON tblmarktRueckgabe.MarktID = tblverleih.fkMarktID_Rueckgabe
                                                    ORDER BY VerleihID DESC');
     
                    $stmt_verleih->execute();
                    $verleihe = $stmt_verleih->fetchAll(PDO::FETCH_ASSOC);

                    $stmt_kunden = $pdo->prepare("SELECT KundenID, Vorname, Nachname, PLZ FROM tblkunden");
                    $stmt_kunden->execute();
                    $kunden = $stmt_kunden->fetchAll(PDO::FETCH_ASSOC);

                    
                ?>

                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Verleih-ID</th>
                            <th>KundenID</th>
                            <th>Nachname</th>
                            <th>Vorname</th>
                            <th>PLZ</th>
                            <th>WerkzeugID</th>
                            <th>WKZ Bezeichnung</th>
                            <th>Start</th>
                            <th>Markt_Ausleihe</th>
                            <th>Ende</th>
                            <th>Markt_Rueckgabe</th>
                            <th>Bearb.</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($verleihe AS $verleih): ?>    
                        <tr>
                            <td><?php echo $verleih['VerleihID']; ?></td>
                            <td><?php echo $verleih['fkKundenID']; ?></td>
                            <td><?php echo $verleih['Nachname']; ?></td>
                            <td><?php echo $verleih['Vorname']; ?></td>
                            <td><?php echo $verleih['PLZ']; ?></td>
                            <td><?php echo $verleih['fkWerkzeugID']; ?></td>
                            <td><?php echo $verleih['WerkzeugBezeichnung']; ?></td>
                            <td><?php echo "am " . date("d.m.Y", strtotime($verleih['Start'])) . " um " . date("H:i", strtotime($verleih['Start'])) . " Uhr"; ?></td>
                            <td><?php echo $verleih['MarktAusleihe']; ?></td>
                            <td><?php if ($verleih['Ende'] == NULL) {
                                 echo ""; 
                            } else {
                                echo "am " . date("d.m.Y", strtotime($verleih['Ende'])) . " um " . date("H:i", strtotime($verleih['Ende'])) . " Uhr"; 
                            } ?>
                            </td>
                            <td><?php echo $verleih['MarktRueckgabe']; ?></td>
                            <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rueckgabeEditModal"
                                    onclick="ladenRueckgabeBearbeitenDaten('<?= $verleih['VerleihID'] ?>', '<?= $verleih['fkKundenID'] ?>', '<?= $verleih['fkWerkzeugID'] ?>', '<?= $verleih['Start'] ?>', '<?= $verleih['Ende'] ?>', '<?= $verleih['fkMarktID_Ausleihe'] ?>', '<?= $verleih['fkMarktID_Rueckgabe'] ?>')">
                                Rückgabe
                            </button>
    
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verleihEditModal"
                                    onclick="ladenVerleihBearbeitenDaten('<?= $verleih['VerleihID'] ?>', '<?= $verleih['fkKundenID'] ?>', '<?= $verleih['fkWerkzeugID'] ?>', '<?= $verleih['Start'] ?>', '<?= $verleih['Ende'] ?>', '<?= $verleih['fkMarktID_Ausleihe'] ?>', '<?= $verleih['fkMarktID_Rueckgabe'] ?>')">
                                Bearbeiten
                            </button>
                            <button onclick="openDeleteConfirmModal(<?php echo $verleih['VerleihID']; ?>)" class="btn btn-danger">Löschen</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>   
                
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verleihModal">
                Neuen Verleih hinzufügen
                </button>


            </div>
                        
            <div id="divContent3" class="content bg-white p-3" style="<?php echo $section == 'werkzeuganlegen' ? '' : 'display: none;'; ?>">
           
            <?php // Kundendaten abrufen und anzeigen ?>

                <?php

                    $stmt_werkzeug = $pdo->prepare("SELECT * FROM tblWerkzeuge");
                    $stmt_werkzeug->execute();
                    $werkzeuge = $stmt_werkzeug->fetchAll(PDO::FETCH_ASSOC);


                    
                ?>

                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Bezeichnung</th>
                            <th>Bearb.</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($werkzeuge AS $werkzeug): ?>    
                        <tr>
                            <td><?php echo $werkzeug['WerkzeugeID']; ?></td>
                            <td><?php echo $werkzeug['WerkzeugBezeichnung']; ?></td>
                            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bearbeitenWerkzeugModal" onclick="ladenWerkzeug('<?= $werkzeug['WerkzeugeID'] ?>', '<?= $werkzeug['WerkzeugBezeichnung'] ?>')">
                                Bearb.
                            </button>
                            <button onclick="openDeleteConfirmWerkzeugModal(<?php echo $werkzeug['WerkzeugeID']; ?>)" class="btn btn-danger">Löschen</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>   

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#werkzeugModal">Neues Werkzeug hinzufügen</button>

            </div>

            <div id="divContent4" class="content bg-white p-3" style="<?php echo $section == 'maerkte' ? '' : 'display: none;'; ?>">
            
                        <?php // Kundendaten abrufen und anzeigen ?>

            <?php

                $stmt_markt = $pdo->prepare("SELECT * FROM tblMarkt");
                $stmt_markt->execute();
                $maerkte = $stmt_markt->fetchAll(PDO::FETCH_ASSOC);


                
            ?>

            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Markt</th>
                        <th>Bearb.</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($maerkte AS $markt): ?>    
                    <tr>
                        <td><?php echo $markt['MarktID']; ?></td>
                        <td><?php echo $markt['MarktName']; ?></td>
                        <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bearbeitenMarktModal" onclick="ladenMarkt('<?= $markt['MarktID'] ?>', '<?= $markt['MarktName'] ?>')">
                            Bearb.
                        </button>
                        <button onclick="openDeleteConfirmMarktModal(<?php echo $markt['MarktID']; ?>)" class="btn btn-danger">Löschen</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>   

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#marktModal">Neue Markt hinzufügen</button>


            </div>


    <aside id="asideRechts" class="bg-light p-3">Aside 2</aside>

    </div>
    
    <div>
        <footer class="bg-dark text-white p-3">Copyright 2024 by Markus Klausriegler</footer>
    </div>






    <!-- Modal -->
    <div class="modal fade" id="kundenModal" tabindex="-1" aria-labelledby="kundenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kundenModalLabel">Neuen Kunden hinzufügen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="kundenForm" action="kunden_insert.php" method="post">
                        <div class="mb-3">
                            <label for="anrede" class="form-label">Anrede</label>
                            <select class="form-select" id="anrede" name="anrede">
                            <?php foreach ($anreden as $anrede): ?>
                                <option value="<?php echo $anrede['AnredeID']; ?>"><?php echo $anrede['Anrede']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="titel" class="form-label">Titel</label>
                            <select class="form-select" id="titel" name="titel">
                            <?php foreach ($titeln as $titel): ?>
                                <option value="<?php echo $titel['TitelID']; ?>"><?php echo $titel['Titel']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="vorname" class="form-label">Vorname</label>
                            <input type="text" class="form-control" id="vorname" name="vorname" required>
                        </div>
                        <div class="mb-3">
                            <label for="nachname" class="form-label">Nachname</label>
                            <input type="text" class="form-control" id="nachname" name="nachname" required>
                        </div>
                        <div class="mb-3">
                            <label for="geschlecht" class="form-label">Geschlecht</label>
                            <select class="form-select" id="geschlecht" name="geschlecht">
                            <?php foreach ($geschlechter as $geschlecht): ?>
                                <option value="<?php echo $geschlecht['GeschlechtID']; ?>"><?php echo $geschlecht['Geschlecht']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="strasse" class="form-label">Straße</label>
                            <input type="text" class="form-control" id="strasse" name="strasse" required>
                        </div>
                        <div class="mb-3">
                            <label for="plz" class="form-label">PLZ</label>
                            <input type="text" class="form-control" id="plz" name="plz" required>
                        </div>
                        <div class="mb-3">
                            <label for="ort" class="form-label">Ort</label>
                            <input type="text" class="form-control" id="ort" name="ort" required>
                        </div>
                        <div class="mb-3">
                            <label for="telnr" class="form-label">Telefonnummer</label>
                            <input type="text" class="form-control" id="telnr" name="telnr" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Speichern</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Bearbeiten-Kunden-Modal -->
<div class="modal fade" id="bearbeitenKundenModal" tabindex="-1" aria-labelledby="bearbeitenKundenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bearbeitenKundenModalLabel">Kundendaten bearbeiten</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bearbeitenKundenForm" action="kunden_update.php" method="post">
                    <input type="hidden" id="editKundenID" name="kundenID">
                    <div class="mb-3">
                        <label for="editAnrede" class="form-label">Anrede</label>
                        <select class="form-select" id="editAnrede" name="anrede">
                        <?php foreach ($anreden as $anrede): ?>
                                <option value="<?php echo $anrede['AnredeID']; ?>"><?php echo $anrede['Anrede']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editTitel" class="form-label">Titel</label>
                        <select class="form-select" id="editTitel" name="titel">
                        <?php foreach ($titeln as $titel): ?>
                                <option value="<?php echo $titel['TitelID']; ?>"><?php echo $titel['Titel']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editVorname" class="form-label">Vorname</label>
                        <input type="text" class="form-control" id="editVorname" name="vorname">
                    </div>
                    <div class="mb-3">
                        <label for="editNachname" class="form-label">Nachname</label>
                        <input type="text" class="form-control" id="editNachname" name="nachname">
                    </div>
                    <div class="mb-3">
                        <label for="editGeschlecht" class="form-label">Geschlecht</label>
                        <select class="form-select" id="editGeschlecht" name="geschlecht">
                        <?php foreach ($geschlechter as $geschlecht): ?>
                                <option value="<?php echo $geschlecht['GeschlechtID']; ?>"><?php echo $geschlecht['Geschlecht']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStrasse" class="form-label">Straße</label>
                        <input type="text" class="form-control" id="editStrasse" name="strasse">
                    </div>
                    <div class="mb-3">
                        <label for="editPLZ" class="form-label">PLZ</label>
                        <input type="text" class="form-control" id="editPLZ" name="plz">
                    </div>
                    <div class="mb-3">
                        <label for="editOrt" class="form-label">Ort</label>
                        <input type="text" class="form-control" id="editOrt" name="ort">
                    </div>
                    <div class="mb-3">
                        <label for="editTelnr" class="form-label">Telefonnummer</label>
                        <input type="text" class="form-control" id="editTelnr" name="telnr">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="bearbeitenKundenForm" class="btn btn-primary">Änderungen speichern</button>
            </div>
        </div>
    </div>
</div>

<!-- Löschbestätigungs-Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Kunden löschen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sind Sie sicher, dass Sie diesen Kunden löschen möchten?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                <button type="button" class="btn btn-danger" id="deleteConfirmButton">Löschen</button>
            </div>
        </div>
    </div>
</div>

<!-- Werkzeug Modal -->
<div class="modal fade" id="werkzeugModal" tabindex="-1" aria-labelledby="werkzeugModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="werkzeugModalLabel">Neues Werkzeug hinzufügen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="werkzeugForm" action="werkzeug_insert.php" method="post">
                    <div class="mb-3">
                        <label for="werkzeug" class="form-label">Werkzeug Bezeichnung</label>
                        <input type="text" class="form-control" id="werkzeug" name="werkzeug" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Speichern</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bearbeiten-Werkzeug-Modal für Kunden-->
<div class="modal fade" id="bearbeitenWerkzeugModal" tabindex="-1" aria-labelledby="bearbeitenWerkzeugModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bearbeitenWerkzeugModalLabel">Werkzeug bearbeiten</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bearbeitenWerkzeugForm" action="werkzeug_update.php" method="post">
                    <input type="hidden" id="editWerkzeugID" name="WerkzeugID">
                    <div class="mb-3">
                        <label for="editWerkzeug" class="form-label">Werkzeug Bezeichnung</label>
                        <input type="text" class="form-control" id="editWerkzeug" name="werkzeug">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="bearbeitenWerkzeugForm" class="btn btn-primary">Änderungen speichern</button>
            </div>
        </div>
    </div>
</div>


<!-- Löschbestätigungs-Modal für Werkeuge-->
<div class="modal fade" id="deleteConfirmWerkzeugeModal" tabindex="-1" aria-labelledby="deleteConfirmWerkzeugeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmWerkzeugeModalLabel">Werkzeug löschen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sind Sie sicher, dass Sie dieses Werkzeug löschen möchten?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                <button type="button" class="btn btn-danger" id="deleteConfirmButton">Löschen</button>
            </div>
        </div>
    </div>
</div> 


<!-- Markt Modal -->
<div class="modal fade" id="marktModal" tabindex="-1" aria-labelledby="marktModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="marktModalLabel">Neuen Markt hinzufügen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="marktForm" action="markt_insert.php" method="post">
                    <div class="mb-3">
                        <label for="markt" class="form-label">Markt Name</label>
                        <input type="text" class="form-control" id="markt" name="markt" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Speichern</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bearbeiten-Markt-Modal-->
<div class="modal fade" id="bearbeitenMarktModal" tabindex="-1" aria-labelledby="bearbeitenMarktModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bearbeitenMarktModalLabel">Markt bearbeiten</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bearbeitenMarktForm" action="markt_update.php" method="post">
                    <input type="hidden" id="editMarktID" name="MarktID">
                    <div class="mb-3">
                        <label for="editMarkt" class="form-label">Markt Name</label>
                        <input type="text" class="form-control" id="editMarkt" name="markt">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="bearbeitenMarktForm" class="btn btn-primary">Änderungen speichern</button>
            </div>
        </div>
    </div>
</div>


<!-- Löschbestätigungs-Modal für Markt-->
<div class="modal fade" id="deleteConfirmMarktModal" tabindex="-1" aria-labelledby="deleteConfirmMarktModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmMarktModalLabel">Markt löschen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sind Sie sicher, dass Sie diesen Markt löschen möchten?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                <button type="button" class="btn btn-danger" id="deleteConfirmButton">Löschen</button>
            </div>
        </div>
    </div>
</div>


<!-- Verleih Modal -->
    <div class="modal fade" id="verleihModal" tabindex="-1" aria-labelledby="verleihModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verleihModalLabel">Neuen Verleih hinzufügen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="kundenForm" action="verleih_insert.php" method="post">
                        <div class="mb-3">
                            <label for="kunde" class="form-label">Kunde</label>
                            <select class="form-select" id="kunde" name="kunde">
                            <?php foreach ($kunden as $kunde): ?>
                                <option value="<?php echo $kunde['KundenID']; ?>"><?php echo $kunde['KundenID'] . " " . $kunde['Nachname'] . " " . $kunde['Vorname'] . " " . $kunde['PLZ']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="werkzeug" class="form-label">Werkzeug</label>
                            <select class="form-select" id="werkzeug" name="werkzeug">
                            <?php foreach ($werkzeuge as $werkzeug): ?>
                                <option value="<?php echo $werkzeug['WerkzeugeID']; ?>"><?php echo $werkzeug['WerkzeugeID'] . " " . $werkzeug['WerkzeugBezeichnung']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="start" class="form-label">Start</label>
                            <input type="datetime-local" class="form-control" id="start" name="start" required>
                        </div>
                        <div class="mb-3">
                            <label for="markt_ausleihe" class="form-label">Markt Ausleihe</label>
                            <select class="form-select" id="markt_ausleihe" name="markt_ausleihe">
                            <?php foreach ($maerkte as $markt): ?>
                                <option value="<?php echo $markt['MarktID']; ?>"><?php echo $markt['MarktID'] . " " . $markt['MarktName']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Speichern</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Verleih Bearbeiten Modal -->
<div class="modal fade" id="verleihEditModal" tabindex="-1" aria-labelledby="verleihEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verleihEditModalLabel">Verleih bearbeiten</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="verleihEditForm" action="verleih_update.php" method="post">
                    <input type="hidden" id="editVerleihID" name="verleihID">
                    <div class="mb-3">
                        <label for="editKundenID2" class="form-label">Kunde</label>
                        <select class="form-select" id="editKundenID2" name="kundenID">
                        <?php foreach ($kunden as $kunde): ?>
                                <option value="<?php echo $kunde['KundenID']; ?>"><?php echo $kunde['KundenID'] . " " . $kunde['Nachname'] . " " . $kunde['Vorname'] . " " . $kunde['PLZ']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editWerkzeugID2" class="form-label">Werkzeug</label>
                        <select class="form-select" id="editWerkzeugID2" name="werkzeugID">
                        <?php foreach ($werkzeuge as $werkzeug): ?>
                                <option value="<?php echo $werkzeug['WerkzeugeID']; ?>"><?php echo $werkzeug['WerkzeugeID'] . " " . $werkzeug['WerkzeugBezeichnung']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStart" class="form-label">Startdatum und -zeit</label>
                        <input type="datetime-local" class="form-control" id="editStart" name="start">
                    </div>
                    <div class="mb-3">
                        <label for="editEnde" class="form-label">Enddatum und -zeit</label>
                        <input type="datetime-local" class="form-control" id="editEnde" name="ende">
                    </div>
                    <div class="mb-3">
                        <label for="editMarktID_Ausleihe" class="form-label">Markt Ausleihe</label>
                        <select class="form-select" id="editMarktID_Ausleihe" name="marktID_Ausleihe">
                            <?php foreach ($maerkte as $markt): ?>
                                    <option value="<?php echo $markt['MarktID']; ?>"><?php echo $markt['MarktID'] . " " . $markt['MarktName']; ?></option>
                                    <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editMarktID_Rueckgabe" class="form-label">Markt Rückgabe</label>
                        <select class="form-select" id="editMarktID_Rueckgabe" name="marktID_Rueckgabe">
                            <?php foreach ($maerkte as $markt): ?>
                                        <option value="<?php echo $markt['MarktID']; ?>"><?php echo $markt['MarktID'] . " " . $markt['MarktName']; ?></option>
                                        <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Änderungen speichern</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Verleih-Rückgabe Bearbeiten Modal -->
<div class="modal fade" id="rueckgabeEditModal" tabindex="-1" aria-labelledby="rueckgabeEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rueckgabeEditModalLabel">Rückgabe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rueckgabeEditForm" action="verleih_rueckgabe.php" method="post">
                    <input type="hidden" id="VerleihID" name="verleihID">
                    <div class="mb-3">
                        <label for="rueckgabeEnde" class="form-label">Enddatum und -zeit</label>
                        <input type="datetime-local" class="form-control" id="rueckgabeEnde" name="ende">
                    </div>
                    <div class="mb-3">
                        <label for="rueckgabeMarktID_Rueckgabe" class="form-label">Markt Rückgabe</label>
                        <select class="form-select" id="rueckgabeMarktID_Rueckgabe" name="marktID_Rueckgabe">
                            <?php foreach ($maerkte as $markt): ?>
                                        <option value="<?php echo $markt['MarktID']; ?>"><?php echo $markt['MarktID'] . " " . $markt['MarktName']; ?></option>
                                        <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Änderungen speichern</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Löschbestätigungs-Modal für Verleih -->
<div class="modal fade" id="deleteVerleihConfirmModal" tabindex="-1" aria-labelledby="deleteVerleihConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteVerleihConfirmModalLabel">Verleih löschen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Sind Sie sicher, dass Sie diesen Verleih löschen möchten?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn btn-danger" id="deleteVerleihConfirmButton">Löschen</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


<script>
    function ladenKundenDaten(kundenID, anredeID, titelID, vorname, nachname, geschlechtID, strasse, plz, ort, telnr) {

        document.getElementById('editKundenID').value = kundenID;
        document.getElementById('editAnrede').value = anredeID;
        document.getElementById('editTitel').value = titelID;
        document.getElementById('editVorname').value = vorname;
        document.getElementById('editNachname').value = nachname;
        document.getElementById('editGeschlecht').value = geschlechtID;
        document.getElementById('editStrasse').value = strasse;
        document.getElementById('editPLZ').value = plz;
        document.getElementById('editOrt').value = ort;
        document.getElementById('editTelnr').value = telnr;
    }


    function ladenWerkzeug(werkzeugID, werkzeugBezeichnung) {

        document.getElementById('editWerkzeugID').value = werkzeugID;
        document.getElementById('editWerkzeug').value = werkzeugBezeichnung;
    }

    function openDeleteConfirmModal(kundenId) {
    $('#deleteConfirmButton').data('id', kundenId); 
    $('#deleteConfirmModal').modal('show');
    }

    $('#deleteConfirmButton').click(function() {
        var kundenId = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'kunden_delete.php', 
            data: { id: kundenId },
            success: function(response) {
                $('#deleteConfirmModal').modal('hide');
                location.reload(); 
            },
            error: function(xhr, status, error) {
                alert('Ein Fehler ist aufgetreten: ' + error);
            }
        });
    });

    function openDeleteConfirmWerkzeugModal(werkzeugeId) {
        $('#deleteConfirmButton').data('id', werkzeugeId); 
        $('#deleteConfirmModal').modal('show');
    }

    $('#deleteConfirmButton').click(function() {
        var werkzeugeId = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'werkzeug_delete.php', 
            data: { id: werkzeugeId },
            success: function(response) {
                $('#deleteConfirmModal').modal('hide');
                location.reload(); 
            },
            error: function(xhr, status, error) {
                alert('Ein Fehler ist aufgetreten: ' + error);
            }
        });
    });


    function ladenMarkt(marktID, marktName) {

        document.getElementById('editMarktID').value = marktID;
        document.getElementById('editMarkt').value = marktName;
        }

    function openDeleteConfirmMarktModal(marktId) {
        $('#deleteConfirmButton').data('id', marktId); 
        $('#deleteConfirmModal').modal('show');
        }
    
    function ladenVerleihBearbeitenDaten(verleihID, kundenID, werkzeugID, start, ende, marktID_Ausleihe, marktID_Rueckgabe) {
        document.getElementById('editVerleihID').value = verleihID;
        document.getElementById('editKundenID2').value = kundenID; 
        document.getElementById('editWerkzeugID2').value = werkzeugID; 
        document.getElementById('editStart').value = start; 
        document.getElementById('editEnde').value = ende; 
        document.getElementById('editMarktID_Ausleihe').value = marktID_Ausleihe; 
        document.getElementById('editMarktID_Rueckgabe').value = marktID_Rueckgabe; 
    }            

    function ladenRueckgabeBearbeitenDaten(verleihID, kundenID, werkzeugID, start, ende, marktID_Ausleihe, marktID_Rueckgabe) {
        document.getElementById('rueckgabeVerleihID').value = verleihID;
        document.getElementById('rueckgabeKundenID2').value = kundenID; 
        document.getElementById('rueckgabeWerkzeugID2').value = werkzeugID; 
        document.getElementById('rueckgabeStart').value = start; 
        document.getElementById('rueckgabeEnde').value = ende; 
        document.getElementById('rueckgabeMarktID_Ausleihe').value = marktID_Ausleihe; 
        document.getElementById('rueckgabeMarktID_Rueckgabe').value = marktID_Rueckgabe; 
    }            









    $('#deleteConfirmButton').click(function() {
        var marktId = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'markt_delete.php', 
            data: { id: marktId },
            success: function(response) {
                $('#deleteConfirmModal').modal('hide');
                location.reload(); 
            },
            error: function(xhr, status, error) {
                alert('Ein Fehler ist aufgetreten: ' + error);
            }
        });
    });
    

document.getElementById('verleihEditForm').addEventListener('submit', function(e) {
    e.preventDefault(); 
    var formData = new FormData(this); 
    fetch('verleih_update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) { 
            console.log("Update erfolgreich");
            $('#verleihEditModal').modal('hide'); 
            console.error('Serverfehler beim Update');
        }
    })
    .catch(error => console.error('Fehler:', error)); 
});

document.getElementById('rueckgabeEditForm').addEventListener('submit', function(e) {
    e.preventDefault(); 
    var formData = new FormData(this); 
    fetch('verleih_rueckgabe.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) { 
            console.log("Update erfolgreich");
            $('#rueckgabeEditModal').modal('hide'); 
            console.error('Serverfehler beim Update');
        }
    })
    .catch(error => console.error('Fehler:', error)); 
});

</script>

</body>
</html>