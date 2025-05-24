<?php

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


function nav_menu(string $linkClass = ''):string {
    return 
        nav_item("/index.php", "Accueil", $linkClass) .
        nav_item("/form.php", "Enregistrer une session", $linkClass) .
        nav_item("/recapitulatif.php", "Mes sessions", $linkClass) .
        nav_item("#", "Mon compte", $linkClass);
}