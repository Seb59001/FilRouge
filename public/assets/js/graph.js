 console.log('test');

const canvas = document.getElementById('monGraphique')
const graph = new Chart(canvas, {
type: 'pie',
data: {
    label: ['Absents', 'Présents'], 
    datasets: [{
        data: [4,1]

    }]
},
options: {}
});