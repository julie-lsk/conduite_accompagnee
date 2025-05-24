<?php require "functions.php"; ?>

<header>
    <section class="hdp">
        <div class="hdp-infos">
            <a href="index.php">
                <img src="assets/ecf_logo.png" alt="Logo de l'auto-école ECF Obernai">
            </a>
            <div class="hdp-nom">
                <h1>ECF ORAKIN - OBERNAI</h1>
                <p>Groupe LLERENA</p>
            </div>
        </div>
        <a class="btn-primaire" href="/formulaire.php">Enregistrer une session</a>
    </section>
    <nav>
        <ul class="navbar">
            <?php 
                echo nav_menu('nav-link');
            ?>
        </ul>
        <img src="assets/avis.png" alt="Avis et certification">
    </nav>
</header>