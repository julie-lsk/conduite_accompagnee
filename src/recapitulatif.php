<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes sessions de conduite accompagnée</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/recapitulatif.css">
    <link rel="icon" type="image/x-icon" href="./assets/ecf_logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php 
        require __DIR__ . '/data.php';

        $champsExpConduite = getExpConduite();
        $champsManoeuvres = getManoeuvres();
    ?>

</head>

<body>

    <?php require 'components/header.php'; ?>
    
    <main>

        <div class="recap-hdp-texte-sessions">
            <h2>Mes expériences de conduite</h2>
    
            <h3>Bravo ! Tu as parcouru 
                <strong> 
                    <?php 
                        $somme = 0;
                        foreach($champsExpConduite as $item):
                            $somme += intval($item['km']);
                        endforeach;
                        echo $somme;
                    ?> 
                </strong> km sur 3 000 !
            </h3>
        </div>            

        <table>
            <thead>
                <tr>
                    <th scope="col">Date de la session</th>
                    <th scope="col">Heure de début</th>
                    <th scope="col">Heure de fin</th>
                    <th scope="col">Kilomètres parcourus</th>
                    <th scope="col">Météo</th>
                    <th scope="col">Type de route</th>
                    <th scope="col">Type de trafic</th>
                    <th scope="col">Manoeuvres réalisées</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    // Données qu'on souhaite afficher
                    $elementsToDisplay = ['dateExpConduite', 'heure_debut', 'heure_fin', 'km', 'nomMeteo', 'typeRouteNom', 'typeTrafic'];

                    // Noms des manoeuvres
                    $manoeuvres = convertIdToStringManoeuvres();

                    foreach($champsExpConduite as $expConduite):
                        $idExp = $expConduite['idExpConduite'];

                        echo "<tr>";
                            
                            // On choisit les champs d'expConduite à afficher 
                            champsExpConduite($expConduite, $elementsToDisplay);

                            // Affichage les manoeuvres en lien avec l'idExpConduite actuel
                            echo "<td>";
                                if(isset($manoeuvres[$idExp])):
                                    // Transforme un tableau en une chaîne de caractères (dont les éléments sont séparés par des ,)
                                    echo implode(' - ', $manoeuvres[$idExp]);
                                else:
                                    echo "Aucune manoeuvre réalisée";
                                endif;
                            echo "</td>";

                        echo "</tr>";
                    endforeach;
                ?>
            </tbody>
        </table>
        
    </main>

    <?php require 'components/footer.php'; ?>
    
</body>

<script src="/index.js"></script>

</html>
