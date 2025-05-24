<?php require "functions.php"; ?>

<header>
    <section class="hdp">
        <div class="hdp-infos">
            <img src="./assets/ecf_logo.png" alt="Logo de l'auto-école ECF Obernai">
            <div class="hdp-nom">
                <h1>ECF ORAKIN - OBERNAI</h1>
                <p>Groupe LLERENA</p>
            </div>
        </div>
        <button class="btn-primaire">Enregistrer une session</button>
    </section>
    <nav>
        <ul class="navbar">
            <?php 
                echo nav_menu('nav-link');
            ?>
        </ul>
        <img src="./assets/avis.png" alt="Logo de l'auto-école ECF Obernai">
    </nav>
</header>