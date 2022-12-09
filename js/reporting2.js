function updateChart2() {
  async function fetchData2() {
    const url2 = 'http://localhost/slash2/sphere.json';
    const response2 = await fetch(url2);

    const datapoints = await response2.json();
    console.log(datapoints);
    return datapoints;
  };

  async function fetchData6() {
    const url3 = 'http://localhost/slash2/sphere.json';
    const response3 = await fetch(url3);

    const datapoints2 = await response3.json();
    console.log(datapoints2);
    return datapoints2;
  };

  fetchData2().then(datapoints2 => {
    const shpereMetier = datapoints2.spheres.map(
      function(index){
       return (index.total);
      })

      // var modifiedBrands = passengers.outer_attribute.brands.map(function(arrayCell){
      //   return {...arrayCell, customer_visit_ratio: (arrayCell.customer_visit_ratio* 100).toFixed(2)};
      // });
      // passengers.outer_attribute.brands = modifiedBrands ;
      // console.log('passengers', passengers);
      
      console.log(shpereMetier);
      graph.data.datasets[0].data = shpereMetier;
      graph.update();
  });

  fetchData6().then(datapoints => {
    const shpereLabel = datapoints.spheres.map(
      function(index){
        return index.label;
      })

      console.log(shpereLabel);
      graph.data.labels = shpereLabel;
      graph.update();
  });
}

window.addEventListener("load", myInit, true); function myInit(){updateChart2()}; 


let ctx = document.querySelector("#chartCanvas2")
        let graph = new Chart(ctx, {
          type: "pie",
          data: {
            labels: [""],
            datasets: [
              {
                data: [""],
                backgroundColor: [
                  "#2490F6",
                  "#2ED82E"
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
              tooltip: {
                enabled: true,
                callbacks: {
                  footer: (ttItem) => {
                    let sum = 0;
                    let dataArr = ttItem[0].dataset.data;
                    dataArr.map(data => {
                      sum += Number(data);
                    });
        
                    let percentage = (ttItem[0].parsed * 100 / sum).toFixed(2) + '%';
                    return `Total: ${percentage}`;
                  }
                }
              },
              labels: {
                render: 'percentage',
                precision: 2
              },
              title: {
                display: true,
                text: "Type de métiers",
                position: "top",
                padding: {
                  bottom: 30,
                }
              },
              legend: {
                display: true,
                position: "bottom",
                padding: {
                    top : 300
                }
              }
            }
          }
        });