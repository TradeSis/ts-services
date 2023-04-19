<?php
// helio 01022023 alterado para include_once
// gabriel 03022023 alterado visualizar

include_once '../head.php';
include_once '../database/tarefas.php';
include_once '../database/demanda.php';



$tarefas = buscaTarefas();
/*$cards1 = buscaCards("");
$cards2 = buscaCards("WHERE idTipoStatus=4");
$cards3 = buscaCards("WHERE status=0");
$cards4 = buscaCards(""); */


?>

<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">

<body class="bg-transparent">
  <div class="container-fluid py-2">
    <div class="header-body">
      <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total de Chamados</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                      /*foreach ($cards1 as $card1)
                                                                        echo $card1['total']; */
                                                                      ?>
                    <span style="font-size: 10px"> / Demandas</span></h5>
                  </div>
                </div>
                <div class="col-auto">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Abertos</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                      /*foreach ($cards2 as $card2)
                                                                        echo $card2['total']; */
                                                                      ?>
                    <span style="font-size: 10px"> / Demandas</span></h5>
                  </div>
                </div>
                <div class="col-auto">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Fechados</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                      /*foreach ($cards2 as $card2)
                                                                        echo $card2['total']; */
                                                                      ?>
                    <span style="font-size: 10px"> / Demandas</span></h5>
                  </div>
                </div>
                <div class="col-auto">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Em Desenvolvimento</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                      /*foreach ($cards2 as $card2)
                                                                        echo $card2['total']; */
                                                                      ?>
                    <span style="font-size: 10px"> / Demandas</span></h5>
                  </div>
                </div>
                <div class="col-auto">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="container-fluid text-center pt-2 mt-3">
    
      <div class="col-sm-3 ml-2">
        <p class="tituloTabela">Tarefas</p>
      </div>
      <div class="table table-sm table-hover table-bordered">
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th>ID</th>
              <th>Titulo</th>
              <th>Cliente</th>
              <th>Demanda</th>
              <th>Atendente</th>
              <th>Data Início</th>
              <th>Data Fim</th>
              <th>Duração</th>
              <th>Status</th>
              <th>Ação</th>
            </tr>
          </thead>

          <?php
          foreach ($tarefas as $tarefa) {
          ?>
            <tr>
              <td><?php echo $tarefa['idTarefa'] ?></td>
              <td><?php echo $tarefa['tituloTarefa'] ?></td>
              <td><?php echo $tarefa['nomeCliente'] ?></td>
              <td><?php echo $tarefa['tituloDemanda'] ?></td>
              <td><?php echo $tarefa['nomeUsuario'] ?></td>
              <td><?php echo $tarefa['dataExecucaoInicio'] ?></td>
              <td><?php echo $tarefa['dataExecucaoFinal'] ?></td>
              <td><?php echo $tarefa['tempo'] ?></td>
              <td><?php echo $tarefa['nomeTipoStatus'] ?></td>
              <td>
                <a class="btn btn-primary btn-sm" href="visualizar.php?idDemanda=<?php echo $tarefa['idDemanda'] ?>" role="button"><i class="bi bi-eye-fill"></i></a>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>
    
  </div>


</body>

</html>