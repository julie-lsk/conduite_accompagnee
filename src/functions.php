<?php

// ********** Header **********
// Création des items
function nav_item(string $lien, string $titre, string $linkClass = ''):string {

    if($_SERVER['SCRIPT_NAME'] === $lien) {
        $linkClass .= ' ' .'active';
    }

    return <<<NAV
        <li class="nav-item">
            <a class="$linkClass" href='$lien'>$titre</a>
        </li>
    NAV;
}

// Personnalisation des items
function nav_menu(string $linkClass = ''):string {
    return 
        nav_item("/index.php", "Accueil", $linkClass) .
        nav_item("/formulaire.php", "Enregistrer une session", $linkClass) .
        nav_item("/recapitulatif.php", "Mes sessions", $linkClass) .
        nav_item("#", "Mon compte", $linkClass);
}

// ********** Choix des variables d'un ExpConduite à afficher **********
function champsExpConduite(array $expConduite, array $elementsToDisplay, bool $affichageTableau = true):array {
    $valeursFormatees = [];
    
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

        if ($affichageTableau):
            echo "<td>" . $value . "</td>";
        else:
            $valeursFormatees[] = $value;
        endif;
    endforeach;

    return $valeursFormatees;
}