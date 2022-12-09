function updateChart3() {

    async function fetchData3() {
      const url = 'http://localhost/slash2/recettes_depenses.json';
      const response = await fetch(url);
  
      const datapoints = await response.json();
      console.log(datapoints);
      return datapoints;
    };

    async function fetchData5() {
      const url2 = 'http://localhost/slash2/events2.json';
      const response2 = await fetch(url2);
  
      const datapoints2 = await response2.json();
      console.log(datapoints2);
      return datapoints2;
    };

    async function fetchData4() {
        const url = 'http://localhost/slash2/recettes_depenses.json';
        const response = await fetch(url);
    
        const datapoints = await response.json();
        console.log(datapoints);
        return datapoints;
      };
  
    fetchData3().then(datapoints => {
      const depense = datapoints.recettesDepenses.map(
        function(index){
          return index.depense;
        })
        
        console.log(depense);
        graph2.data.datasets[0].data = depense;
        graph2.update();
    });

    fetchData5().then(datapoints2 => {
      const nom = datapoints2.evenements.map(
        function(index){
          return index.nom_evenement;
        })

        console.log(nom);
        graph2.data.labels = nom;
        graph2.update();
    });

    fetchData4().then(datapoints => {
        const recette = datapoints.recettesDepenses.map(
          function(index){
            return index.recette;
          })
          
          console.log(recette);
          graph3.data.datasets[0].data = recette;
          graph3.update();
      });

    fetchData5().then(datapoints => {
        const nom = datapoints.evenements.map(
          function(index){
            return index.nom_evenement;
          })
          
          console.log(nom);
          graph3.data.labels = nom;
          graph3.update();
      });
  };

  window.addEventListener("load", myInit2, true); function myInit2(){updateChart3()}; 


let ctx2 = document.querySelector("#chartCanvas3")
        let graph2 = new Chart(ctx2, {
            type: "polarArea",
            data: {
                labels: [''],
                datasets: [{
                    data: [''],
                    backgroundColor: ['#fc4a50', '#2490F6', '#2ED82E', '#C39D78', '#fc8823']
                }]
                // {
                //     label: 'Nombre de "J\'aime"',
                //     data: [14, 2, 5, 8, 7, 22],
                //     backgroundColor: ['red', 'lightblue', 'lightyellow', 'lightgreen', 'pink', 'gold']
                // }]
            },
            options: {
                plugins:{
                    // tooltip: {
                    //     callbacks: {
                    //       label: function(context) {
                    //         let label = context.dataset.labels || '';
                
                    //         if (label) {
                    //           label += ': ';
                    //         }
                    //         if (context.parsed.y !== null) {
                    //           label += new Intl.NumberFormat('en-US', {
                    //             style: 'currency',
                    //             currency: 'USD'
                    //           }).format(context.parsed.y);
                    //         }
                    //         return label;
                    //       }
                    //     }
                    // },
                    title: {
                        display: true,
                        text: "Dépenses",
                        position: 'top',
                        padding: {
                            bottom: 30
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                    }
                }
                // scales: {
                //     yAxes: [{
                //         ticks: {
                //             beginAtZero: true
                //         }
                //     }]
                // }
            }
        })

let ctx3 = document.querySelector("#chartCanvas4")
        let graph3 = new Chart(ctx3, {
            type: "bar",
            data: {
                labels: [""],
                datasets: [{
                    data: [''],
                    backgroundColor: ['#fc4a50', '#2490F6', '#2ED82E', '#C39D78', '#fc8823', '#ffff55']
                }]
                // {
                //     label: 'Nombre de "J\'aime"',
                //     data: [14, 2, 5, 8, 7, 22],
                //     backgroundColor: ['red', 'lightblue', 'lightyellow', 'lightgreen', 'pink', 'gold']
                // }]
            },
            options: {
                plugins:{
                    title: {
                        display: true,
                        text: "Recettes",
                        position: 'top',
                        padding: {
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false,
                        position: 'bottom',
                    }
                }
                // scales: {
                //     yAxes: [{
                //         ticks: {
                //             beginAtZero: true
                //         }
                //     }]
                // }
            }
        })