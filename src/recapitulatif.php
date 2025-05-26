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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <?php 
        require __DIR__ . '/data.php';

        $champsExpConduite = getExpConduite();
    ?>

    <!-- <pre><?php var_dump($champsExpConduite) ?></pre> -->

</head>

<body>

    <?php require 'components/header.php'; ?>
    
    <main>

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
                    // Itération sur les tableaux du tableau d'expérience de conduite
                    $elementsToDisplay = ['dateExpConduite', 'heure_debut', 'heure_fin', 'km', 'nomMeteo', 'typeRouteNom', 'typeTrafic'];
                    
                    foreach($champsExpConduite as $expConduite):
                        echo "<tr>";
                        
                        // On choisit les champs d'expConduite à afficher 
                        foreach ($elementsToDisplay as $item):
                            $value = $expConduite[$item];

                            // Formatage de la date
                            if($item == "dateExpConduite"):
                                $date = new DateTime($value);
                                $value = $date->format('j F o');
                            endif;

                            // Formatage de l'heure
                            if($item == "heure_debut" || $item == "heure_fin"):
                                $heure = new DateTime($value);
                                $value = $heure->format('h:i');
                            endif;

                            echo "<td>" . $value . "</td>";
                        endforeach;

                        echo "</tr>";
                    endforeach;
                ?>
            </tbody>
        </table>
        
    </main>

    <?php require 'components/footer.php'; ?>
    
</body>
</html>
