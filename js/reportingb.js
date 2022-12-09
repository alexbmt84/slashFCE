function updateChartData() {
    async function fetchDatas() {
      const nurl = 'http://localhost/slash2/metiers.json';
      const nresponse2 = await fetch(nurl);
  
      const ndatapoints = await nresponse2.json();
      console.log(ndatapoints);
      return ndatapoints;
    };
  
    async function fetchDatas1() {
      const nurl1 = 'http://localhost/slash2/metiers.json';
      const nresponse3 = await fetch(nurl1);
  
      const ndatapoints1 = await nresponse3.json();
      console.log(ndatapoints1);
      return ndatapoints1;
    };
  
    fetchDatas().then(ndatapoints => {
      const metierLabel = ndatapoints.metiers.map(
        function(index){
         return (index.id_utilisateur);
        })
  
        // var modifiedBrands = passengers.outer_attribute.brands.map(function(arrayCell){
        //   return {...arrayCell, customer_visit_ratio: (arrayCell.customer_visit_ratio* 100).toFixed(2)};
        // });
        // passengers.outer_attribute.brands = modifiedBrands ;
        // console.log('passengers', passengers);
        
        console.log(metierLabel);
        ngraph.data.datasets[0].data = metierLabel;
        ngraph.update();
    });
  
    fetchDatas1().then(ndatapoints1 => {
      const metier = ndatapoints1.metiers.map(
        function(index){
          return index.nom;
        })
  
        console.log(metier);
        ngraph.data.labels = metier;
        ngraph.update();
    });
  }
  
  window.addEventListener("load", myInit3, true); function myInit3(){updateChartData()}; 
  
  
  let nctx = document.querySelector("#chartCanvas5")
          let ngraph = new Chart(nctx, {
            type: "pie",
            data: {
              labels: [""],
              datasets: [
                {
                  data: [""],
                  backgroundColor: [
                    '#fc4a50', '#2490F6', '#2ED82E', '#C39D78', '#fc8823', '#ffff55'
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
                  text: "Liste des métiers",
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