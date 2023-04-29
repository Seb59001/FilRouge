
const canvas = document.getElementById('monGraphique');
const graph = new Chart(canvas, {
type: 'pie',
data: {
    labels: ['Absents', 'Présents'], 
    datasets: [{
        data: [4,1]

    }]
},
options: {}
});