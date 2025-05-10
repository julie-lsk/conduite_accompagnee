flatpickr("#heureDebut", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
});
flatpickr("#heureFin", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
});

// Données JSON pour remplir dynamiquement les listes déroulantes du formulaire
const donneesConduite = {
    meteo: [
        { id: 1, label: "Ensoleillée" },
        { id: 2, label: "Pluie" },
        { id: 3, label: "Brouillard" },
        { id: 4, label: "Neige" },
        { id: 5, label: "Vent" },
        { id: 6, label: "Orage" },
        { id: 7, label: "Nuageux" },
        { id: 8, label: "Canicule" },
        { id: 9, label: "Grêle" },
        { id: 10, label: "Averses" },
        { id: 11, label: "Tempête" },
        { id: 12, label: "Gel" }
    ],
    // Autres listes pour les variables de trafic, environnement, etc.
    trafic: [
        { id: 1, label: "Faible" },
        { id: 2, label: "Modéré" },
        { id: 3, label: "Fort" },
        { id: 4, label: "Fluctuant" }
    ],
    environnement: [
        { id: 1, label: "Citadin" },
        { id: 2, label: "Rural" },
        { id: 3, label: "Autoroutier" },
        { id: 4, label: "Montagnard" }
    ],
    manoeuvre: [
        { id: 1, label: "Stationnement en épi" },
        { id: 2, label: "Stationnement en bataille" },
        { id: 3, label: "Stationnement en créneau" }
    ],
    typeRoute: [
        { id: 1, label: "Nationale" },
        { id: 2, label: "Départementale" },
        { id: 3, label: "Autoroute" },
        { id: 4, label: "Centre-ville" },
        { id: 5, label: "Mixte" }
    ],
    transport: [
        { id: 1, label: "Trafic important" },
        { id: 2, label: "Accident de la route" },
        { id: 3, label: "Travaux routiers" },
        { id: 4, label: "Embouteillage" },
        { id: 5, label: "Obstacle sur la route" },
        { id: 6, label: "Routes fermées" }
    ]
};

// Fonction pour générer les options de liste déroulante en utilisant les données JSON
function generateOptions(selectId, options, placeholder) {
    const selectElement = document.getElementById(selectId);
    selectElement.innerHTML = "";  // Vide le contenu existant

    selectElement.insertAdjacentHTML('beforeend', `<option value="" disabled selected hidden>${placeholder}</option>`);
    // Ajoute chaque option à la liste déroulante
    options.forEach(option => {
        selectElement.insertAdjacentHTML('beforeend', `<option value="${option.id}">${option.label}</option>`);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    // Génère les options pour chaque liste déroulante du formulaire
    generateOptions('meteo', donneesConduite.meteo, "Choisissez la météo");
    generateOptions('trafic', donneesConduite.trafic, "Choisissez le trafic");
    generateOptions('environnement', donneesConduite.environnement, "Choisissez l'environnement");
    generateOptions('manoeuvre', donneesConduite.manoeuvre, "Choisissez la manoeuvre");
    generateOptions('typeRoute', donneesConduite.typeRoute, "Choisissez le type de route");
    generateOptions('transport', donneesConduite.transport, "Choisissez l'événement");
    calculerDistanceTotale();  // Met à jour la distance totale dès le chargement


    //Ici ça permet de sélectionner plusieurs réponses
    //en gros on va prendre le nom du select, enlever le fonctionnement par défaut et 
    //regarder s'il est sélectionné ou non et inverser cette info(en gros, on clique sur un sélectionné, ça le déselectionner, on clique un déselectionné ça le sélectionner)
    function selectMultiple(selectName){ 
        var select = document.getElementById(selectName); 
        select.addEventListener('mousedown', function(e) {
        e.preventDefault();
        var select = this;
        var index = Array.from(select.options).indexOf(e.target);
        if (e.target.tagName.toLowerCase() !== 'option' || index === -1) return;
        select.options[index].selected = !select.options[index].selected;
        return false;
        }
        );
    }
    
    //on lance la fonction de sélection multiple
    selectMultiple('environnement');
    selectMultiple('manoeuvre');
    selectMultiple('typeRoute');
    selectMultiple('transport');

    // Gestionnaire de soumission de formulaire
    const formElement = document.getElementById("form");
    formElement.addEventListener("submit", function(event) {
        event.preventDefault();  // Empêche le rechargement de la page lors de l'enregistrement

        // Récupère les valeurs des champs du formulaire
        const experience = {
            date: document.getElementById("date").value,
            heureDebut: document.getElementById("heureDebut").value,
            heureFin: document.getElementById("heureFin").value,
            km: parseFloat(document.getElementById("km").value),
            meteo: document.getElementById("meteo").value,
            trafic: document.getElementById("trafic").value,
            environnement: getValidSelectedOptions("environnement"),
            manoeuvre: getValidSelectedOptions("manoeuvre"),
            typeRoute: getValidSelectedOptions("typeRoute"),
            transport: getValidSelectedOptions("transport")
        };

        // Fonction pour récupérer les options valides, en excluant "0" si c'est la seule option sélectionnée
        function getValidSelectedOptions(selectId) {
            const selectedOptions = Array.from(document.getElementById(selectId).selectedOptions);

            // Extrait les valeurs des options sélectionnées
            const values = selectedOptions.map(option => option.value);

            // Vérifie si toutes les options sélectionnées sont invalides (valeurs vides ou nulles)
            // Si aucune option n'est sélectionnée, retourne [0]
            if (values.length === 0 || values.every(value => value === "" || value === null)) {
                return [0];  // Retourne 0 si aucune option valide n'est sélectionnée
            }

            // Filtre les valeurs invalides ("" et null), on garde les autres
            const validValues = values.filter(value => value !== "" && value !== null);

            // Si seulement "0" est sélectionné, on l'ignore
            if (validValues.length === 1 && validValues[0] === "0") {
                return []; // Ignore "0" si c'est le seul sélectionné
            }

            return validValues;
        }

        // Récupère les expériences stockées dans le localStorage, ou crée un tableau vide
        let experiences = JSON.parse(localStorage.getItem("experiences")) || [];
        experience.id = experiences.length > 0 ? experiences[experiences.length - 1].id + 1 : 1;  // Incrémente l'ID
        experiences.push(experience);  // Ajoute la nouvelle expérience
        localStorage.setItem("experiences", JSON.stringify(experiences));  // Sauvegarde dans le localStorage

        alert("Expérience de conduite enregistrée !");
        formElement.reset();  // Réinitialise le formulaire après soumission
        calculerDistanceTotale();  // Met à jour la distance totale
    });
});


// Calcul de la distance totale parcourue
function calculerDistanceTotale() {
    const experiences = JSON.parse(localStorage.getItem("experiences")) || [];
    const distanceTotale = experiences.reduce((acc, experience) => acc + experience.km, 0);
    document.getElementById("bilanDistance").innerText = `Distance totale parcourue : ${distanceTotale} km`;
}

// Bouton de réinitialisation des données
document.getElementById("resetButton").addEventListener("click", function () {
    const codeInput = document.getElementById("resetCode").value.trim();
    const correctCode = "CAT";  

    // Vérification du code de réinitialisation
    if (codeInput === correctCode) {
        localStorage.removeItem("experiences");
        calculerDistanceTotale();  // Mise à jour après suppression des données
        alert("La distance totale a été remise à zéro.");
        document.getElementById("resetCode").value = "";
    } else {
        alert("Erreur. Impossible de réinitialiser.");
    }
});

// Affichage ou masquage de la page de bilan
let viewBilanButtons = document.querySelectorAll(".viewBilanButton")
viewBilanButtons.forEach(button => {
    button.addEventListener("click", function () {
        const bilanPage = document.getElementById("bilanPage");
        bilanPage.style.display = bilanPage.style.display === "none" ? "block" : "none";
        
        if (bilanPage.style.display === "block") {
            updateBilan();
        }
    });
});

// Application des filtres sur les expériences
document.getElementById("applyFiltersButton").addEventListener("click", function () {
    updateBilan();
});

function getLabelsById(list, ids) {
    if (!Array.isArray(ids)) {
        ids = [ids]; 
    }
    return ids.map(id => {
        const match = list.find(item => item.id == id);
        return match ? match.label : ``;
    });
}

function displayDetailedExperiences(containerId, experiences) {
    const container = document.getElementById(containerId);
    container.innerHTML = ""; // Efface les données précédentes

    if (experiences.length === 0) {
        container.innerHTML = "<p>Aucune expérience trouvée pour les critères sélectionnés.</p>";
        return;
    }

    // Crée un tableau HTML
    const table = document.createElement("table");
    table.classList.add("stat-table");
    table.classList.add("hidden")

    // Ajoute l'en-tête
    const header = document.createElement("tr");
    const headers = ["Date", "Heure début", "Heure fin", "Météo", "Kilomètres", "Type de route", "Manœuvres", "Transport", "Trafic", "Environnement"];
    headers.forEach(text => {
        const th = document.createElement("th");
        th.innerText = text;
        header.appendChild(th);
    });
    table.appendChild(header);

    // Ajoute les données des expériences
    experiences.forEach(exp => {
        const row = document.createElement("tr");

        // Ajoute chaque donnée dans une cellule
        const dateCell = document.createElement("td");
        dateCell.innerText = exp.date || "N/A";
        row.appendChild(dateCell);

        const heureDebutCell = document.createElement("td");
        heureDebutCell.innerText = exp.heureDebut || "N/A";
        row.appendChild(heureDebutCell);

        const heureFinCell = document.createElement("td");
        heureFinCell.innerText = exp.heureFin || "N/A";
        row.appendChild(heureFinCell);

        const meteoCell = document.createElement("td");
        meteoCell.innerText = getLabelsById(donneesConduite.meteo, exp.meteo).join(", ");
        row.appendChild(meteoCell);

        const kmCell = document.createElement("td");
        kmCell.innerText = exp.km || "0";
        row.appendChild(kmCell);

        const routeCell = document.createElement("td");
        routeCell.innerText = getLabelsById(donneesConduite.typeRoute, exp.typeRoute).join(", ");
        row.appendChild(routeCell);

        const manoeuvreCell = document.createElement("td");
        manoeuvreCell.innerText = getLabelsById(donneesConduite.manoeuvre, exp.manoeuvre).join(", ");
        row.appendChild(manoeuvreCell);

        const transportCell = document.createElement("td");
        transportCell.innerText = getLabelsById(donneesConduite.transport, exp.transport).join(", ");
        row.appendChild(transportCell);

        const traficCell = document.createElement("td");
        traficCell.innerText = getLabelsById(donneesConduite.trafic, exp.trafic).join(", ");
        row.appendChild(traficCell);

        const environnementCell = document.createElement("td");
        environnementCell.innerText = getLabelsById(donneesConduite.environnement, exp.environnement).join(", ");
        row.appendChild(environnementCell);

        

        table.appendChild(row);
    });

    container.appendChild(table);
}

// Met à jour la page de bilan avec les statistiques
function updateBilan() {
    const experiences = JSON.parse(localStorage.getItem("experiences")) || [];
    const filterDate = document.getElementById("filterDate").value;
    const filterCondition = document.getElementById("filterCondition").value;

    // Filtre les expériences en fonction des critères choisis
    let filteredExperiences = experiences;
    if (filterDate) {
        filteredExperiences = filteredExperiences.filter(exp => exp.date === filterDate);
    }
    if (filterCondition) {
        filteredExperiences = filteredExperiences.filter(exp => exp.meteo === filterCondition);
    }

    // Calcul des statistiques sur les expériences filtrées
    const totalExperiences = filteredExperiences.length;
    const totalKilometers = filteredExperiences.reduce((acc, exp) => acc + exp.km, 0);
    const averageKilometers = totalExperiences > 0 ? (totalKilometers / totalExperiences).toFixed(2) : 0;

    // Comptabilise les expériences par type en tenant compte des tableaux
    const experiencesByCondition = {};
    const experiencesByRouteType = {};
    const experiencesByManoeuvre = {};
    const experiencesByTransport = {};

    filteredExperiences.forEach(exp => {
        // Comptabiliser les conditions météo
        const meteoLabel = getLabelsById(donneesConduite.meteo, exp.meteo);
        experiencesByCondition[meteoLabel] = (experiencesByCondition[meteoLabel] || 0) + 1;

        // Comptabiliser les types de route (gestion de multiples options)
        if (Array.isArray(exp.typeRoute)) {
            exp.typeRoute.forEach(route => {
                const routeLabel = getLabelsById(donneesConduite.typeRoute, route);
                experiencesByRouteType[routeLabel] = (experiencesByRouteType[routeLabel] || 0) + 1;
            });
        } else {
            const routeLabel = getLabelsById(donneesConduite.typeRoute, exp.typeRoute);
            experiencesByRouteType[routeLabel] = (experiencesByRouteType[routeLabel] || 0) + 1;
        }

        // Comptabiliser les manœuvres (gestion de multiples options)
        if (Array.isArray(exp.manoeuvre)) {
            exp.manoeuvre.forEach(manoeuvre => {
                const manoeuvreLabel = getLabelsById(donneesConduite.manoeuvre, manoeuvre);
                experiencesByManoeuvre[manoeuvreLabel] = (experiencesByManoeuvre[manoeuvreLabel] || 0) + 1;
            });
        } else {
            const manoeuvreLabel = getLabelsById(donneesConduite.manoeuvre, exp.manoeuvre);
            experiencesByManoeuvre[manoeuvreLabel] = (experiencesByManoeuvre[manoeuvreLabel] || 0) + 1;
        }

        // Comptabiliser les événements de transport (gestion de multiples options)
        if (Array.isArray(exp.transport)) {
            exp.transport.forEach(transport => {
                const transportLabel = getLabelsById(donneesConduite.transport, transport);
                experiencesByTransport[transportLabel] = (experiencesByTransport[transportLabel] || 0) + 1;
            });
        } else {
            const transportLabel = getLabelsById(donneesConduite.transport, exp.transport);
            experiencesByTransport[transportLabel] = (experiencesByTransport[transportLabel] || 0) + 1;
        }
    });

    // Met à jour les statistiques globales
    document.getElementById("totalExperiences").innerText = `Nombre total d'expériences : ${totalExperiences}`;
    document.getElementById('totalKilometers').innerText = `Nombre total de kilomètres parcourus : ${totalKilometers} km`;
    document.getElementById("averageKilometers").innerText = `Moyenne des kilomètres parcourus : ${averageKilometers} km`;

    // Affiche les données sous forme de tableau pour chaque catégorie
    displayStatTable("experiencesByCondition", experiencesByCondition);
    displayStatTable("experiencesByRouteType", experiencesByRouteType);
    displayStatTable("experiencesByManoeuvre", experiencesByManoeuvre);
    displayStatTable("experiencesByTransport", experiencesByTransport);

    // Affiche les expériences détaillées
    displayDetailedExperiences("statisticsByExperience", filteredExperiences);
}

// Affiche un objet de données statistiques dans un tableau
function displayStatTable(tableId, data) {
    const tbody = document.getElementById(tableId);
    tbody.innerHTML = "";
    Object.entries(data).forEach(([key, value]) => {
        const row = `<tr><td>${key}</td><td>${value}</td></tr>`;
        tbody.insertAdjacentHTML("beforeend", row);
    });
}

// Fonction pour télécharger les données en JSON ou CSV
function downloadData(format) {
    const experiences = JSON.parse(localStorage.getItem("experiences")) || [];
    let dataStr = "";

    if (format === "json") {
        dataStr = JSON.stringify(experiences, null, 2);
        const blob = new Blob([dataStr], { type: "application/json" });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = "experiences.json";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    } else if (format === "csv") {
        dataStr = "ID,Date,Heure Début,Heure Fin,Kilométrage,Météo,Trafic,Environnement,Manœuvre,Type de Route,Transport\n";
        experiences.forEach(exp => {
            dataStr += `${exp.id},${exp.date},${exp.heureDebut},${exp.heureFin},${exp.km},${exp.meteo},${exp.trafic},${exp.environnement},${exp.manoeuvre},${exp.typeRoute},${exp.transport}\n`;
        });
        const blob = new Blob([dataStr], { type: "text/csv" });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = "experiences.csv";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }
}

// Boutons pour télécharger en JSON ou CSV
let downloadJsonButton = document.querySelectorAll(".downloadJsonButton")
downloadJsonButton.forEach(button =>{
    button.addEventListener("click", () => downloadData("json"));
})

let downloadCsvButton = document.querySelectorAll(".downloadCsvButton")
downloadCsvButton.forEach(button =>{
    button.addEventListener("click", () => downloadData("csv"));
})