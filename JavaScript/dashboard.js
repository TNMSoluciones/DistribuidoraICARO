'use strict';
const xValues = [1,2,3,4,5,6,7,8,9,10,11,12];

let xmlPorMes = new XMLHttpRequest();
xmlPorMes.overrideMimeType('text/xml');
const data = {
    tipo: 'dataPorMes'
}
xmlPorMes.onreadystatechange = function (){
    if (this.status==200 && this.readyState==4) {
        console.log(this.response);
        const ganadopormes = JSON.parse(this.response);
        new Chart("myChart", {
            type: "line",
            data: {
            labels: xValues,
                datasets: [{
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(0,0,255,1.0)",
                borderColor: "rgba(255,175,101,.6)",
                data: ganadopormes
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Ingresos Mensuales',
                    fontSize:20,
                    fontFamiliy:"'Roboto Condensed', 'sans-serif'",
                    fontColor: '#000'
                
                },
                legend: {display: false},
                scales: {
                    xAxes: [{ticks: {min: 1, max:12}}],
                }
            }
            });
    }
}
xmlPorMes.open('POST', 'ajax/dashboard.php', true);
xmlPorMes.send(JSON.stringify(data));
