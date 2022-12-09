// This demo uses the Chartjs javascript library
// Simple yet flexible JavaScript charting for designers & developers
// Webite: https://www.chartjs.org
// CDN: https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js

const percent = 80;
const color = '#ffffff';
const canvas = 'chartCanvas';
const container = 'chartContainer';

const percentValue = percent; // Sets the single percentage value
const colorwhite = color, // Sets the chart color
animationTime = '1400'; // Sets speed/duration of the animation

const chartFigure = document.getElementById("chart__figure");
const chartCanvas = document.getElementById(canvas); // Sets canvas element by ID
const chartContainer = document.getElementById(container); // Sets container element ID


const pPercent = document.createElement("p");//.appendChild("chart__figure");
pPercent.setAttribute("id", "pourcentage");
pPercent.innerText = percentValue + "%";

chartFigure.appendChild(pPercent);

// Create a new Chart object
const doughnutChart = new Chart(chartCanvas, {
  type: 'doughnut', // Set the chart to be a doughnut chart type
  data: {
    datasets: [
    {
      data: [percentValue, 100 - percentValue], // Set the value shown in the chart as a percentage (out of 100)
      backgroundColor: [colorwhite], // The background color of the filled chart
      borderWidth: 0 // Width of border around the chart
    }] },


  options: {
    cutoutPercentage: 80, // The percentage of the middle cut out of the chart
    responsive: false, // Set the chart to not be responsive
    tooltips: {
      enabled: false // Hide tooltips
    } } });



Chart.defaults.global.animation.duration = animationTime; // Set the animation duration

divElement.innerHTML = domString; // Parse the HTML set in the domString to the innerHTML of the divElement
chartContainer.appendChild(divElement.firstChild); // Append the divElement within the chartContainer as it's child