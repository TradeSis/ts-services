<?php
// helio 01022023 alterado para include_once
// gabriel 03022023 alterado visualizar

include_once '../head.php';
include_once '../database/tarefas.php';
include_once '../database/demanda.php';

$tarefas = buscaTarefas();
$dadosGrafico1 = buscaTarefasGrafico1();
$dadosGrafico2 = buscaTarefasGrafico2();
$dadosGrafico3 = buscaTarefasGrafico3();
$dadosGrafico4 = buscaTarefasGrafico4();

?>



<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
      drawColumnChart();
      drawPieChart();
      drawDonutChart();
    }

    function drawPieChart() {
      var jsonDataObj = <?php echo json_encode($dadosGrafico2); ?>;
      var data = new google.visualization.DataTable();

      data.addColumn('string', 'Tamanho');
      data.addColumn('number', 'Total');

      for (var i = 0; i < jsonDataObj.length; i++) {
        var row = jsonDataObj[i];
        data.addRow([row.tamanho, parseInt(row.total)]);
      }

      var options = {
        width: 600,
        height: 400,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }

    function drawDonutChart() {
      var jsonDataObj = <?php echo json_encode($dadosGrafico3); ?>;
      var data = new google.visualization.DataTable();

      data.addColumn('string', 'Tipo de Ocorrência');
      data.addColumn('number', 'Total');

      for (var i = 0; i < jsonDataObj.length; i++) {
        var row = jsonDataObj[i];
        data.addRow([row.nomeTipoOcorrencia, parseInt(row.total)]);
      }

      var options = {
        width: 600,
        height: 400,
        pieHole: 0.4,
      };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);
    }
    function drawColumnChart() {
      var jsonDataObj = <?php echo json_encode($dadosGrafico4) ?>;
      var data = new google.visualization.DataTable();

      data.addColumn('string', 'Month');
      data.addColumn('number', 'Ajuste Base');
      data.addColumn('number', 'Ajuste Programa');
      data.addColumn('number', 'Consultoria');
      data.addColumn('number', 'Projeto');
      data.addColumn('number', 'Reunião');
      data.addColumn('number', 'Sem problemas');

      for (var year in jsonDataObj) {
        for (var month in jsonDataObj[year]) {
          var row = jsonDataObj[year][month];
          var rowData = [row[0]['Mes']];
          rowData.push(getTotalByOcorrencia(row, 'Ajuste Base'));
          rowData.push(getTotalByOcorrencia(row, 'Ajuste Programa'));
          rowData.push(getTotalByOcorrencia(row, 'Consultoria'));
          rowData.push(getTotalByOcorrencia(row, 'Projeto'));
          rowData.push(getTotalByOcorrencia(row, 'Reunião'));
          rowData.push(getTotalByOcorrencia(row, 'Sem problemas'));
          data.addRow(rowData);
        }
      }

      var options = {
        width: 800,
        height: 300,
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '60%' },
        isStacked: true,
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }

    function getTotalByOcorrencia(data, ocorrencia) {
      var total = 0;
      for (var i = 0; i < data.length; i++) {
        if (data[i].nomeTipoOcorrencia === ocorrencia) {
          total += timeToHours(data[i].total);
        }
      }
      return total;
    }

    function timeToHours(time) {
      var parts = time.split(':');
      var hours = parseInt(parts[0]);
      var minutes = parseInt(parts[1]) / 60;
      var seconds = parseInt(parts[2]) / 3600;
      return hours + minutes + seconds;
    }
  </script>
</head>

<body class="bg-transparent">
  <div class="container-fluid mt-4">
    <div class="card">
      <div class="card-header">
        <h3>Dashboard Tarefas</h3>
      </div>
      <div class="row">
        <div class="col-md-4 text-center" style="margin-right: -30px;">
          <div class="card-header">
            <h5>Demandas no Mês</h5>
          </div>
          <div class="col my-2">
            <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2 mb-2 p-1">
                  <div class="text-xs font-weight-bold text-secondary text-uppercase text-success">Abertas neste Mês</div>
                  <div class="h5 mb-0  text-gray-800 ml-1">
                    <?php echo $dadosGrafico1['totalDemandas'] ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col my-2">
            <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2 mb-2 p-1">
                  <div class="text-xs font-weight-bold text-secondary text-info text-uppercase ">Em Análise</div>
                  <div class="h5 mb-0  text-gray-800 ml-1">
                    <?php echo $dadosGrafico1['totalAbertos'] ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col my-2">
            <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2 mb-2 p-1">
                  <div class="text-xs font-weight-bold text-secondary text-warning text-uppercase ">Solucionadas</div>
                  <div class="h5 mb-0  text-gray-800 ml-1">
                    <?php echo $dadosGrafico1['totalSolucionados'] ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8 text-center">
          <div class="card-header">
            <h5>Tempo Médio de Demandas (Ano)</h5>
          </div>
          <center>
            <div id="chart_div"></div>
          </center>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 text-center" style="margin-right: -30px;">
          <div class="card-header">
            <h5>Status das Demandas (Mês)</h5>
          </div>
          <center>
            <div id="donutchart"></div>
          </center>
        </div>
        <div class="col-md-6 text-center">
          <div class="card-header">
            <h5>Demandas por Tamanho (Mês)</h5>
          </div>
          <center>
            <div id="piechart"></div>
          </center>
        </div>
      </div>
    </div>
  </div>
</body>


</html>

