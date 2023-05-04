// On récupère l'élément canvas où sera affiché le graphique
const canvas = document.getElementById('graphique');

// On crée un nouveau graphique de type bar
const graph = new Chart(canvas, {
    type: 'bar',
    // On définit les labels (noms de cours)
    data: {
        labels: ['NomDuCours'],
        datasets: [{
            // On définit les données pour la présence
            data: [0],
            backgroundColor: ['#A9BEC7'],
            borderColor: ['#A9BEC7'],
            label: 'Présence'
        },
        {
            // On définit les données pour l'absence
            data: [0],
            backgroundColor: ['#DEBFD2'],
            borderColor: ['#DEBFD2'],
            label: 'Absence'
        }]
    },
    // On définit les options du graphique
    options: {
        plugins: {
            // On ajoute un titre au graphique
            title: {
                text: 'Les statistiques',
                display: true,
                position: 'top'
            },
            // On ajoute une légende en bas du graphique
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Lorsque la page a fini de charger
window.onload = () => {
    // On récupère le formulaire contenant les filtres
    const FiltersForm = document.querySelector("#filters");

    // Pour chaque input du formulaire
    document.querySelectorAll("#filters input").forEach(input => {
        // On ajoute un événement lorsqu'on change la valeur
        input.addEventListener("change", () => {
            // On récupère les cours sélectionnés
            const selectedCourses = Array.from(document.querySelectorAll("#filters input:checked")).map(input => input.value);
            // On récupère les paramètres du formulaire
            const Form = new FormData(FiltersForm);
            const Params = new URLSearchParams();
            Form.forEach((value, key) => {
                Params.append(key, value);
            });
            // On construit l'URL de la requête AJAX
            const Url = new URL(window.location.href);
            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1",{
                headers: {
                    "X-Requested-with": "XMLHttpRequest"
                }
            })
            // On récupère la réponse en JSON
            .then(response => response.json())
            .then(data => {
                // On met à jour les données du graphique avec les données récupérées
                graph.data.datasets[0].data = [data.present];
                graph.data.datasets[1].data = [data.absent];
                // On met à jour le graphique
                graph.update();
            })
            .catch(e => alert(e));
        });
    });
}

