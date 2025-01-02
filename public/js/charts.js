// charts.js
let currentChart = null;

function initChart(ctx) {
   if (currentChart) {
       currentChart.destroy();
   }

   currentChart = new Chart(ctx, {
       type: 'radar',
       data: {
           labels: [],
           datasets: [{
               label: 'Efectivo',
               backgroundColor: 'rgba(59, 130, 246, 0.5)',
               borderColor: 'rgb(59, 130, 246)',
               data: []
           }, {
               label: 'Transferencia',
               backgroundColor: 'rgba(16, 185, 129, 0.5)',
               borderColor: 'rgb(16, 185, 129)',
               data: []
           }, {
               label: 'Tarjeta',
               backgroundColor: 'rgba(245, 158, 11, 0.5)',
               borderColor: 'rgb(245, 158, 11)',
               data: []
           }, {
               label: 'Efectivo Neto',
               backgroundColor: 'rgba(99, 102, 241, 0.5)',
               borderColor: 'rgb(99, 102, 241)',
               data: []
           }]
       },
       options: {
           responsive: true,
           interaction: {
               intersect: false,
               mode: 'index'
           },
           scales: {
               y: {
                   beginAtZero: true,
                   ticks: {
                       callback: value => `$${value.toLocaleString()}`
                   }
               }
           },
           plugins: {
               legend: {
                   position: 'top'
               },
               tooltip: {
                   callbacks: {
                       label: (context) => {
                           return `${context.dataset.label}: $${context.raw.toLocaleString()}`;
                       }
                   }
               }
           }
       }
   });

   return currentChart;
}

function updateChart(data) {
   const ctx = document.getElementById('stats-chart').getContext('2d');
   const chart = initChart(ctx);
   
   const labels = ['Efectivo', 'Transferencia', 'Tarjeta', 'Efectivo Neto'];
    const values = [
        data.stats.find(d => d.metodo_pago === 'Efectivo')?.monto || 0,
        data.stats.find(d => d.metodo_pago === 'Transferencia')?.monto || 0,
        data.stats.find(d => d.metodo_pago === 'Tarjeta')?.monto || 0,
        data.efectivo_neto || 0
    ];


   chart.data.labels = labels;
   chart.data.datasets.forEach((dataset, index) => {
       dataset.data = [values[index]];
   });

   chart.update();
}