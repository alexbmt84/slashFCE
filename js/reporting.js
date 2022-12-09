// This demo uses the Chartjs javascript library
// Simple yet flexible JavaScript charting for designers & developers
// Webite: https://www.chartjs.org
// CDN: https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js
function updateChart() {
  async function fetchData() {
    const url = 'http://localhost/slash2/events2.json';
    const response = await fetch(url);

    const datapoints = await response.json();
    console.log(datapoints);
    return datapoints;
  };

  fetchData().then(datapoints => {
    const nomEvenement = datapoints.evenements.map(
      function(index){
        return index.nom_evenement;
      })

    const dureeEvenement = datapoints.evenements.map(
      function(index){
        return index.dureeEvenement;
      })

      
      console.log(nomEvenement);
      console.log(dureeEvenement);
      doughnutChart.data.labels = nomEvenement;
      doughnutChart.data.datasets[0].data = dureeEvenement;
      doughnutChart.update();
  });
}

const percent = 0;
const color = '#212121';
const canvas = 'chartCanvas';
const container = 'chartContainer';

const percentValue = percent; // Sets the single percentage value
const colorwhite = color, // Sets the chart color
animationTime = '1400'; // Sets speed/duration of the animation

const chartFigure = document.getElementById("chart__figure");
const chartCanvas = document.getElementById(canvas); // Sets canvas element by ID
const chartContainer = document.getElementById(container); // Sets container element ID

const pPercent = document.createElement("p");
pPercent.setAttribute("id", "pourcentage2");
pPercent.innerText = percentValue + "%";

chartFigure.appendChild(pPercent);

// Create a new Chart object
const doughnutChart = new Chart(chartCanvas, {
  type: "doughnut",
  data: {
    labels: [""],
    datasets: [
      {
        data: [],
        backgroundColor: [
          "#FC4A50",
          "#2490F6",
          "#FFDED",
          "#2ED82E",
          "#C39D78",
          "#FC8823",
        ],
      },
    ],
    // {
    //     label: 'Nombre de "J\'aime"',
    //     data: [14, 2, 5, 8, 7, 22],
    //     backgroundColor: ['red', 'lightblue', 'lightyellow', 'lightgreen', 'pink', 'gold']
    // }]
  },

  options: {
    plugins: {
    title: {
      display: true,
      text: "Evénements effectués",
      position: "top",
      padding: {
        bottom: 30
      }
    },
    legend: {
      display: true,
      position: "bottom",
    },
    cutoutPercentage: 80, // The percentage of the middle cut out of the chart
    responsive: false, // Set the chart to not be responsive
    tooltips: {
      enabled: true, // Hide tooltips
    },
  },
}
});

Chart.defaults.global.animation.duration = animationTime; // Set the animation duration

divElement.innerHTML = domString; // Parse the HTML set in the domString to the innerHTML of the divElement
chartContainer.appendChild(divElement.firstChild); // Append the divElement within the chartContainer as it's child