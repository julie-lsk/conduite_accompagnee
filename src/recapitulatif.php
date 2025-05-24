<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes sessions de conduite accompagnée</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="/style.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <?php 
        require __DIR__ . '/data.php'; 
    ?>

</head>

<body>
    <header>
        <h1>Interface conduite accompagnée</h1>
        <div class="footer-buttons">
            <button class="viewBilanButton">Voir le bilan</button>
            <button class="downloadJsonButton">Télécharger JSON</button>
            <button class="downloadCsvButton">Télécharger CSV</button>
        </div>
    </header>
    
    <main>
        
    </main>

    <footer>
        <p>Réalisation : Equipe 3</p>
        <p id="bilanDistance">Distance totale parcourue : 0 km</p>
        <div class="footer-buttons">
            <button class="viewBilanButton">Voir le bilan</button>
            <button class="downloadJsonButton">Télécharger JSON</button>
            <button class="downloadCsvButton">Télécharger CSV</button>
        </div>
        <p>&copy; 2024</p>
    </footer>  
</body>
</html>
