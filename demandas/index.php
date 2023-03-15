<?php
// helio 20022023 - Incluido class="table" no HTML <table>
// Helio 20022023 - integrado modificações para receber idTipoStatus no $_POST
// gabriel 06022023 ajuste na tabela
// helio 01022023 alterado para include_once
// gabriel 01022023 15:07 - order by alterado, visual da tabela linha 119
// helio 26012023 16:16


include_once '../head.php';
include_once '../database/demanda.php';
include_once '../database/tipostatus.php';


$idTipoStatus = null;

if (isset($_POST['idTipoStatus'])) {
  $idTipoStatus = $_POST['idTipoStatus'];
}
$demandas = buscaDemandas(null, $idTipoStatus);
$tiposstatus = buscaTipoStatus();

/*$cards1 = buscaCards("");
$cards2 = buscaCards("WHERE idTipoStatus=4");
$cards3 = buscaCards("WHERE status=0");
$cards4 = buscaCards(""); */


?>
<style rel="stylesheet" type="text/css">
  .estilo1 {
    background-color: #2FB12B;
    border: 0px solid;
  }

  .my-custom-scrollbar {
    position: relative;
    height: 320px;
    overflow: auto;
  }
</style>

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
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                    /*foreach ($cards1 as $card1)
                    echo $card1['total'];*/
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
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
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
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
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
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
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
        <div class="row">
          <div class="col-sm">
            <h4 class="col">Demandas</h4>
          </div>
          <div class="row" style="text-align: right">
            <form class="d-flex" action="index.php" method="post" style="text-align: right;">

            <select class="form-control" name="idTipoStatus" autocomplete="off">
									<?php foreach ($tiposstatus as $tipostatus) { ?>
										<option <?php
                  if ($tipostatus['idTipoStatus'] == $idTipoStatus) {
                    echo "selected";
                  }
                  ?> value="<?php echo $tipostatus['idTipoStatus'] ?>"><?php echo $tipostatus['nomeTipoStatus'] ?></option>
									<?php } ?>
								</select>

              <button type="submit" id="botao" class="btn btn-xl" style="margin-right: 10px"><i
                  class="bi bi-search"></i>buscar</button>

              <div class="col-sm" style="text-align:right">
                <a href="index.php" role="button" class="btn btn-success btn-sm">Limpar</a>
              </div>

            </form>
          </div>

          <div class="col-sm" style="text-align:right">
            <a href="demanda_inserir.php" role="button" class="btn btn-success btn-sm">Adicionar Demanda</a>
          </div>
        </div>
      </div>
      <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar ">
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th class="text-center">Prioridade</th>
              <th class="text-center">ID</th>
              <th class="text-center">Cliente</th>
              <th class="text-center">Demanda</th>
              <th class="text-center">Responsável</th>
              <th class="text-center">Data de Abertura</th>
              <th class="text-center">Status</th>
              <th class="text-center">Ocorrência</th>
              <th class="text-center">Tamanho</th>
              <th class="text-center">Previsão</th>
              <th class="text-center">Ação</th>
            </tr>
          </thead>

          <?php
          foreach ($demandas as $demanda) {
            ?>
            <tr>
              <td class="text-center">
                <?php echo $demanda['prioridade'] ?>
              </td>
              <td class="text-center">
                <?php echo $demanda['idDemanda'] ?>
              </td>
              <td class="text-center">
                <?php echo $demanda['nomeCliente'] ?>
              </td>
              <td class="text-center">
                <?php echo $demanda['tituloDemanda'] ?>
              </td>
              <td class="text-center">
                <?php echo $demanda['nomeUsuario'] ?>
              </td>
              <td class="text-center">
                <?php echo $demanda['dataAbertura'] ?>
              </td>
              <td class="text-center">
                <?php echo $demanda['nomeTipoStatus'] ?>
              </td>
              <td class="text-center">
                <?php echo $demanda['nomeTipoOcorrencia'] ?>
              </td>
              <td class="text-center">
                <?php echo $demanda['tamanho'] ?>
              </td>
              <td class="text-center">
                <?php echo $demanda['horasPrevisao'] ?>
              </td>
              <td class="text-center">
                <a class="btn btn-primary btn-sm" href="visualizar.php?idDemanda=<?php echo $demanda['idDemanda'] ?>"
                  role="button"><i class="bi bi-eye-fill"></i></a>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>


</body>

</html>