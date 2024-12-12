Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
var myPieChart;

function generarGrafico(datos, etiquetas) {
  // Crear el contexto del gráfico
  var ctx = document.getElementById("myPieChart").getContext("2d");

  // Si myPieChart ya está definido, actualizar los datos
  if (myPieChart) {
    myPieChart.data.labels = etiquetas;
    myPieChart.data.datasets[0].data = datos;
    myPieChart.update(); // Redibuja el gráfico
  } else {
    // Crear una nueva instancia de gráfico de tipo pie con datos dinámicos
    myPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: etiquetas,
        datasets: [{
          data: datos,
          backgroundColor: [
            "#4e73df",
            "#1cc88a",
            "#36b9cc",
            "#f6c23e",
            "#e74a3b",
            "#858796",
            "#fd7e14"
          ],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
          borderWidth: 4,
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(50,50,50)",
          bodyFontColor: "#ffffff",
          borderColor: '#ffffff',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: true,
          position: 'right', // Posición de la leyenda a la derecha del gráfico
          align: 'start' // Alinear verticalmente los elementos de la leyenda
        },
        cutoutPercentage: 0,
      },
    });
  }
}