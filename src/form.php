<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie d'une session de conduite accompagnée</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="/style.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- <script src="/index.js"></script> -->

    <?php 
        require __DIR__ . '/data.php'; 
    ?>

</head>

<body>

    <?php require 'components/header.php'; ?>
    
    <main>

        <?php 
            $champsExpConduite = getExpConduite(); 
            $champsManoeuvres= getTypeManoeuvre(); 
            $champsMeteo = getMeteo(); 
            $champsRoute = getTypeRoute(); 
            $champsTrafic = getTypeTrafic(); 
        ?>

        <!-- <pre>
            <?php var_dump($champsMeteo); ?>
        </pre> -->

        <form id="form" action="recapitulatif.php" method="POST">
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
                <!-- </div>

                <div class="droite"> -->
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

        <!-- Page de bilan -->
        <div id="bilanPage" style="display:none">
            <h2>Bilan des Expériences de Conduite</h2>
            <div>
                <label for="filterDate">Filtrer par date :</label>
                <input type="date" id="filterDate">
                
                <label for="filterCondition">Filtrer par condition météo :</label>
                <select id="filterCondition">
                    <option value="">-- Toutes --</option>
                    <option value="1">Ensoleillée</option>
                    <option value="2">Pluie</option>
                    <option value="3">Brouillard</option>
                    <option value="4">Neige</option>
                    <option value="5">Vent</option>
                    <option value="6">Orage</option>
                    <option value="7">Nuageux</option>
                    <option value="8">Canicule</option>
                    <option value="9">Grêle</option>
                    <option value="10">Averses</option>
                    <option value="11">Tempête</option>
                    <option value="12">Gel</option>
                </select>
                
                <button id="applyFiltersButton">Appliquer les filtres</button>
            </div>
            <div id="statistics">
                <p id="totalExperiences">Nombre total d'expériences : 0</p>
                <p id="totalKilometers">Nombre total de kilomètres parcourus : 0 km</p>
                <p id="averageKilometers">Moyenne des kilomètres parcourus : 0 km</p>
                <table class="stat-table">
                    <tr><th>Condition Météo</th><th>Nombre d'expériences</th></tr>
                    <tbody id="experiencesByCondition"></tbody>
                </table>
                <table class="stat-table">
                    <tr><th>Type de Route</th><th>Nombre d'expériences</th></tr>
                    <tbody id="experiencesByRouteType"></tbody>
                </table>
                <table class="stat-table">
                    <tr><th>Type de Manœuvre</th><th>Nombre d'expériences</th></tr>
                    <tbody id="experiencesByManoeuvre"></tbody>
                </table>
                <table class="stat-table">
                    <tr><th>Type de transport</th><th>Nombre d'expériences</th></tr>
                    <tbody id="experiencesByTransport"></tbody>
                </table>
            </div>
            <div id="statisticsByExperience">

            </div>
        </div>
        
    </main>

    <?php require 'components/footer.php'; ?>                        

</body>
</html>
