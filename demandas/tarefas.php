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


  <div class="container-fluid">
    <div class="card shadow">
      <div class="card-header">
        <h3 class="col">Tarefas</h3>
      </div>
      <div class="table table-sm table-hover table-bordered">
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th class="text-center">ID</th>
              <th class="text-center">Titulo</th>
              <th class="text-center">Cliente</th>
              <th class="text-center">Demanda</th>
              <th class="text-center">Atendente</th>
              <th class="text-center">Data Início</th>
              <th class="text-center">Data Fim</th>
              <th class="text-center">Duração</th>
              <th class="text-center">Status</th>
              <th class="text-center">Ação</th>
            </tr>
          </thead>

          <?php
          foreach ($tarefas as $tarefa) {
          ?>
            <tr>
              <td class="text-center"><?php echo $tarefa['idTarefa'] ?></td>
              <td class="text-center"><?php echo $tarefa['tituloTarefa'] ?></td>
              <td class="text-center"><?php echo $tarefa['nomeCliente'] ?></td>
              <td class="text-center"><?php echo $tarefa['tituloDemanda'] ?></td>
              <td class="text-center"><?php echo $tarefa['nomeUsuario'] ?></td>
              <td class="text-center"><?php echo $tarefa['dataExecucaoInicio'] ?></td>
              <td class="text-center"><?php echo $tarefa['dataExecucaoFinal'] ?></td>
              <td class="text-center"><?php echo $tarefa['tempo'] ?></td>
              <td class="text-center"><?php echo $tarefa['nomeTipoStatus'] ?></td>
              <td class="text-center">
                <a class="btn btn-primary btn-sm" href="visualizar.php?idDemanda=<?php echo $tarefa['idDemanda'] ?>" role="button"><i class="bi bi-eye-fill"></i></a>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>


</body>

</html>