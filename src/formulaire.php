<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie d'une session de conduite accompagnée</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/formulaire.css">
    <link rel="icon" type="image/x-icon" href="./assets/ecf_logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- <script src="/index.js"></script> -->

    <?php 
        // Récup des données de base du formulaire
        require __DIR__ . '/data.php'; 

        $champsManoeuvres= getTypeManoeuvre(); 
        $champsMeteo = getMeteo(); 
        $champsRoute = getTypeRoute(); 
        $champsTrafic = getTypeTrafic();
    ?>

</head>

<body>

    <?php require 'components/header.php'; ?>
    
    <main>

        <form id="form" action="form-data.php" method="POST">
            <fieldset>
                <legend>Informations de la session de conduite</legend>
                <div class="gauche">
                    <label for="date">Date de la session :</label>
                    <input type="date" id="date" name="date" required>

                    <label for="heureDebut">Heure de départ :</label>
                    <input type="time" id="heureDebut" name="heureDebut" required>

                    <label for="heureFin">Heure d'arrivée :</label>
                    <input type="time" id="heureFin" name="heureFin" required>

                    <label for="km">Kilométrage parcouru :</label>
                    <input type="number" id="km" name="km" placeholder="20" required min="0">

                    <label for="meteo">Conditions météo :</label>
                    <select id="meteo" name="meteo" required>
                        <option value="" disabled="" selected="" hidden="">Choisissez la météo</option>
                        <?php foreach ($champsMeteo as $champMeteo): ?>
                            <option value="<?= $champMeteo["idMeteo"]?>">
                                <?= $champMeteo["nomMeteo"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="typeRoute">Type de route :</label>
                    <select id="typeRoute" name="typeRoute" required>
                        <option value="" disabled="" selected="" hidden="">Choisissez la route</option>
                        <?php foreach ($champsRoute as $champRoute): ?>
                            <option value="<?= $champRoute["idTypeRoute"]?>">
                                <?= $champRoute["typeRouteNom"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="trafic">Trafic routier :</label>
                    <select id="trafic" name="trafic" required>
                        <option value="" disabled="" selected="" hidden="">Choisissez le trafic</option>
                        <?php foreach ($champsTrafic as $champTrafic): ?>
                            <option value="<?= $champTrafic["idTrafic"] ?>">
                                <?= $champTrafic["typeTrafic"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <p id="titre-manoeuvre">Types de manœuvre :</p>
                    <div class="form-manoeuvres">
                        <?php foreach ($champsManoeuvres as $champManoeuvre): ?>
                            <?php $idManoeuvre = $champManoeuvre["idManoeuvre"] ?>
                            <div class="form-manoeuvre">
                                <input type="checkbox" id="<?= $idManoeuvre ?>" value="<?= $idManoeuvre ?>" name="manoeuvre[]">
                                <label for="<?= $idManoeuvre ?>"><?= $champManoeuvre["manoeuvreNom"] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="submit" id="submitForm">Enregistrer</button>
                <button type="reset" id="resetForm">Réinitialiser</button>
            </fieldset>
        </form>
    </main>

    <?php require 'components/footer.php'; ?>                        

</body>
</html>
