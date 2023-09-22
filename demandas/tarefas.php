<?php
// Gabriel 22092023 id 544 Demandas - Botão Voltar
// gabriel 04082023


include_once(__DIR__ . '/../head.php');
include_once(__DIR__ . '/../database/tarefas.php');
include_once(__DIR__ . '/../database/demanda.php');
include_once(__DIR__ . '/../database/tipoocorrencia.php');
include_once(ROOT . '/cadastros/database/clientes.php');
include_once(ROOT . '/cadastros/database/usuario.php');


$ClienteSession = null;
if (isset($_SESSION['idCliente'])) {
  $ClienteSession = $_SESSION['idCliente'];
}

$clientes = buscaClientes();
$atendentes = buscaAtendente();
$ocorrencias = buscaTipoOcorrencia();
$demandas = buscaDemandasAbertas();


if ($_SESSION['idCliente'] == null) {
  $idCliente = null;
} else {
  $idCliente = $_SESSION['idCliente'];
}

if ($_SESSION['idCliente'] == null) {
  $idAtendente = $_SESSION['idUsuario'];
} else {
  $idAtendente = null;
}
$statusTarefa = "1"; //ABERTO

$Periodo = null;
$filtroEntrada = null;
$idTipoOcorrencia = null;
$PeriodoInicio = null;
$PeriodoFim = null;
$PrevistoOrdem = null;
$RealOrdem = null;


if (isset($_SESSION['filtro_tarefas'])) {
  $filtroEntrada = $_SESSION['filtro_tarefas'];
  $idCliente = $filtroEntrada['idCliente'];
  $idAtendente = $filtroEntrada['idAtendente'];
  $idTipoOcorrencia = $filtroEntrada['idTipoOcorrencia'];
  $statusTarefa = $filtroEntrada['statusTarefa'];
  $Periodo = $filtroEntrada['Periodo'];
  $PeriodoInicio = $filtroEntrada['PeriodoInicio'];
  $PeriodoFim = $filtroEntrada['PeriodoFim'];
  $PrevistoOrdem = $filtroEntrada['PrevistoOrdem'];
  $RealOrdem = $filtroEntrada['RealOrdem'];
}
$previsaoChecked = ($Periodo === '1') ? 'checked' : '';
$realizadoChecked = ($Periodo === '0') ? 'checked' : '';
$Checked = ($Periodo === null) ? 'checked' : '';

?>

</html>

<body class="bg-transparent">

  <nav id="menuFiltros" class="menuFiltros" style="width: 170px;margin-top:-90px;margin-left:11px">
    <div class="titulo"><span>Filtrar por:</span></div>
    <ul>
      <li class="ls-label col-sm-12 mr-1"> <!-- ABERTO/FECHADO -->
        <form class="d-flex" action="" method="post" style="text-align: right;">
          <select class="form-control" name="statusTarefa" id="FiltroStatusTarefa"
            style="font-size: 14px; width: 150px; height: 35px">
            <option value="<?php echo null ?>">
              <?php echo "Todos" ?>
            </option>
            <option <?php if ($statusTarefa == "1") {
              echo "selected";
            } ?> value="1">Aberto</option>
            <option <?php if ($statusTarefa == "0") {
              echo "selected";
            } ?> value="0">Realizado</option>
          </select>
        </form>
      </li>
    </ul>

    <div class="col-sm" style="text-align:right; color: #fff">
      <a onClick="limpar()" role=" button" class="btn btn-sm" style="background-color:#84bfc3; ">Limpar</a>
    </div>
  </nav>


  <div class="container-fluid text-center mt-4">

    <div class="row">
      <div class="btnAbre" style="height:33px">
        <span style="font-size: 25px;font-family: 'Material Symbols Outlined'!important;"
          class="material-symbols-outlined">
          filter_alt
        </span>

      </div>

      <div class="col-sm-3 ml-2">
        <h2 class="tituloTabela">Tarefas</h2>
        <h6 style="font-size: 10px;font-style:italic;text-align:left;">
          <?php
          $var = [];

          if ($statusTarefa != null) {
            $varStatus = ($statusTarefa == 1) ? "Aberto" : "Realizado";
            $var[] = "Status = $varStatus";
          }

          if ($Periodo != null) {
            $varPeriodo = ($Periodo == 1) ? "Previsão" : "Realizado";
            $var[] = "Periodo = $varPeriodo";
            if ($PeriodoInicio != null) {
              $varPeriodoInicio = date('d/m/Y', strtotime($PeriodoInicio));
              $var[] = "De $varPeriodoInicio";

              if ($PeriodoFim != null) {
                $varPeriodoFimFormatted = date('d/m/Y', strtotime($PeriodoFim));
                $var[] = "Até $varPeriodoFimFormatted";
              }
            }
          }

          echo implode(" - ", $var);
          ?>
        </h6>
      </div>

      <!-- <div class="col-sm-4" style="margin-top:-10px;">
        <div class="input-group">
          <input type="text" class="form-control" id="tituloTarefa" placeholder="Buscar por...">
          <span class="input-group-btn">
            <button class="btn btn-primary" id="buscar" type="button" style="margin-top:10px;">
              <span style="font-size: 20px;font-family: 'Material Symbols Outlined'!important;"
                class="material-symbols-outlined">search</span>
            </button>
          </span>
        </div>
      </div> -->
      <div class="col-sm-4">
        <div class="input-group">
          <input type="text" class="form-control" id="buscaTarefa" placeholder="Buscar por id ou titulo">
          <span class="input-group-btn">
            <button class="btn btn-primary mt-2" id="buscar" type="button">
              <span style="font-size: 20px;font-family: 'Material Symbols Outlined'!important;"
                class="material-symbols-outlined">search</span>
            </button>
          </span>
        </div>
      </div>

      <div class="col-sm-1">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#periodoModal"><i
            class="bi bi-calendar3"></i></button>
      </div>

      <div class="col-sm" style="text-align:right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#inserirModal"><i
            class="bi bi-plus-square"></i>&nbsp Novo</button>
      </div>
    </div>


    <div class="card mt-2 text-center">
      <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame">
        <table class="table">
          <thead class="cabecalhoTabela">
            <tr>
              <th>ID</th>
              <th>Tarefa</th>
              <th>Responsável</th>
              <th>Cliente</th>
              <th>Ocorrência</th>
              <th>Previsão</th>
              <th>Real</th>
              <th>Cobrado</th>
              <th style="width: 17%;">Ação</th>
            </tr>
            <tr>
              <th></th>
              <th></th>
              <th>
                <form action="" method="post">
                  <select class="form-control text-center" name="idAtendente" id="FiltroUsuario"
                    style="font-size: 14px;color:#fff; font-style:italic; margin-top:-10px; margin-bottom:-6px;background-color:#13216A">
                    <option value="<?php echo null ?>">
                      <?php echo "Selecione" ?>
                    </option>
                    <?php
                    foreach ($atendentes as $atendente) {
                      ?>
                      <option <?php
                      if ($atendente['idUsuario'] == $idAtendente) {
                        echo "selected";
                      }
                      ?> value="<?php echo $atendente['idUsuario'] ?>">
                        <?php echo $atendente['nomeUsuario'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </form>
              </th>
              <th style="width: 10%;">
                <form action="" method="post">
                  <select class="form-control text-center" name="idCliente" id="FiltroClientes"
                    style="font-size: 14px;color:#fff; font-style:italic; margin-top:-10px; margin-bottom:-6px;background-color:#13216A">
                    <option value="<?php echo null ?>">
                      <?php echo "Selecione" ?>
                    </option>
                    <?php
                    foreach ($clientes as $cliente) {
                      ?>
                      <option <?php
                      if ($cliente['idCliente'] == $idCliente) {
                        echo "selected";
                      }
                      ?> value="<?php echo $cliente['idCliente'] ?>">
                        <?php echo $cliente['nomeCliente'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </form>
              </th>
              <th style="width: 10%;">
                <form action="" method="post">
                  <select class="form-control text-center" name="idTipoOcorrencia" id="FiltroOcorrencia"
                    style="font-size: 14px;color:#fff; font-style:italic; margin-top:-10px; margin-bottom:-6px;background-color:#13216A">
                    <option value="<?php echo null ?>">
                      <?php echo "Selecione" ?>
                    </option>
                    <?php
                    foreach ($ocorrencias as $ocorrencia) {
                      ?>
                      <option <?php
                      if ($ocorrencia['idTipoOcorrencia'] == $idTipoOcorrencia) {
                        echo "selected";
                      }
                      ?> value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>">
                        <?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </form>
              </th>
              <th style="width: 10%;">
                <form action="" method="post">
                  <select class="form-control text-center" name="PrevistoOrdem" id="FiltroPrevistoOrdem"
                    style="font-size: 14px;color:#fff; font-style:italic; margin-top:-10px; margin-bottom:-6px;background-color:#13216A">
                    <option value="<?php echo null ?>">
                      <?php echo "Selecione" ?>
                    </option>
                    <option <?php if ($PrevistoOrdem == "1") {
                      echo "selected";
                    } ?> value="1">DESC</option>
                    <option <?php if ($PrevistoOrdem == "0") {
                      echo "selected";
                    } ?> value="0">ASC</option>
                  </select>
                </form>
              </th>
              <th style="width: 10%;">
                <form action="" method="post">
                  <select class="form-control text-center" name="RealOrdem" id="FiltroRealOrdem"
                    style="font-size: 14px;color:#fff; font-style:italic; margin-top:-10px; margin-bottom:-6px;background-color:#13216A">
                    <option value="<?php echo null ?>">
                      <?php echo "Selecione" ?>
                    </option>
                    <option <?php if ($RealOrdem == "1") {
                      echo "selected";
                    } ?> value="1">DESC</option>
                    <option <?php if ($RealOrdem == "0") {
                      echo "selected";
                    } ?> value="0">ASC</option>
                  </select>
                </form>
              </th>
              <th></th>
              <th style="width: 10%;"></th>
            </tr>
          </thead>

          <tbody id='dados' class="fonteCorpo">

          </tbody>
        </table>
      </div>
    </div>
  </div>


  <!--------- FILTRO PERIODO --------->
  <div class="modal fade bd-example-modal-lg" id="periodoModal" tabindex="-1" role="dialog"
    aria-labelledby="periodoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filtro Periodo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="<?php echo null ?>" id="Radio" name="FiltroPeriodo"
                <?php echo $Checked; ?> hidden>
              <input class="form-check-input" type="radio" value="1" id="PrevisaoRadio" name="FiltroPeriodo" <?php echo $previsaoChecked; ?>>
              <label class="form-check-label" for="PrevisaoRadio">
                Previsão
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="0" id="RealizadoRadio" name="FiltroPeriodo" <?php echo $realizadoChecked; ?>>
              <label class="form-check-label" for="RealizadoRadio">
                Realizado
              </label>
            </div>
            <div class="row" id="conteudoReal">
              <div class="col">
                <label class="labelForm">Começo</label>
                <?php if ($PeriodoInicio != null) { ?>
                <input type="date" class="data select form-control" id="FiltroPeriodoInicio"
                  value="<?php echo $PeriodoInicio ?>" name="PeriodoInicio" autocomplete="off">
                <?php } else { ?>
                <input type="date" class="data select form-control" id="FiltroPeriodoInicio" name="PeriodoInicio"
                  autocomplete="off">
                <?php } ?>
              </div>
              <div class="col">
                <label class="labelForm">Fim</label>
                <?php if ($PeriodoFim != null) { ?>
                <input type="date" class="data select form-control" id="FiltroPeriodoFim"
                  value="<?php echo $PeriodoFim ?>" name="PeriodoFim" autocomplete="off">
                <?php } else { ?>
                <input type="date" class="data select form-control" id="FiltroPeriodoFim" name="PeriodoFim"
                  autocomplete="off">
                <?php } ?>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-sm" style="text-align:left;margin-left:10px">
                <button type="button" class="btn btn-primary" onClick="limparPeriodo()">Limpar</button>
              </div>
              <div class="col-sm" style="text-align:right;margin-right:10px">
                <button type="button" class="btn btn-success" id="filtrarButton" data-dismiss="modal">Filtrar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--------- INSERIR/NOVA --------->
  <div class="modal fade bd-example-modal-lg" id="inserirModal" tabindex="-1" role="dialog"
    aria-labelledby="inserirModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Inserir Tarefa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="container">
          <form method="post" id="inserirForm">
            <div class="row">
              <div class="col-md-6 form-group">
                <label class='control-label' for='inputNormal' style="margin-top: 10px;">Tarefa</label>
                <div class="form-group" style="margin-top: 22px;">
                  <input type="text" class="form-control" name="tituloTarefa" autocomplete="off">
                </div>
                <input type="hidden" class="form-control" name="idDemanda" value="null">
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class='control-label' for='inputNormal'>Cliente</label>
                  <div class="form-group" style="margin-top: 40px;">
                    <select class="form-control" name="idCliente">
                      <option value="null"></option>
                      <?php
                      foreach ($clientes as $cliente) {
                        ?>
                      <option value="<?php echo $cliente['idCliente'] ?>">
                        <?php echo $cliente['nomeCliente'] ?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class='control-label' for='inputNormal'>Reponsável</label>
                  <select class="form-control" name="idAtendente">
                    <?php
                    foreach ($atendentes as $atendente) {
                      ?>
                    <option <?php
                    if ($atendente['idUsuario'] == $idAtendente) {
                      echo "selected";
                    } ?> value="
                      <?php echo $atendente['idUsuario'] ?>">
                      <?php echo $atendente['nomeUsuario'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class='control-label' for='inputNormal'>Ocorrência</label>
                  <select class="form-control" name="idTipoOcorrencia">
                    <option></option>
                    <?php
                    foreach ($ocorrencias as $ocorrencia) {
                      ?>
                    <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>">
                      <?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -14px;">
                <div class="form-group">
                  <label class="labelForm">Horas Cobrado</label>
                  <input type="time" class="data select form-control" name="horaCobrado">
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -20px;">
                <div class="form-group">
                  <label class="labelForm">Data Previsão</label>
                  <input type="date" class="data select form-control" name="Previsto" autocomplete="off" required>
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -20px;">
                <div class="form-group">
                  <label class="labelForm">Inicio</label>
                  <input type="time" class="data select form-control" name="horaInicioPrevisto" autocomplete="off">
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -20px;">
                <div class="form-group">
                  <label class="labelForm">Fim</label>
                  <input type="time" class="data select form-control" name="horaFinalPrevisto" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="card-footer bg-transparent" style="text-align:right">
              <button type="submit" class="btn btn-success">Inserir</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--------- ALTERAR --------->
  <div class="modal fade bd-example-modal-lg" id="alterarmodal" tabindex="-1" role="dialog"
    aria-labelledby="alterarmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alterar Tarefa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="container">
          <form method="post" id="alterarForm">
            <div class="row">
              <div class="col-md-4" style="margin-top: 10px;">
                <div class="form-group">
                  <label class="labelForm">Tarefa</label>
                  <input type="text" class="data select form-control" id="titulo" name="tituloTarefa"
                    autocomplete="off">
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -10px;">
                <div class="form-group" id="demandaContainer">
                  <label class="labelForm">ID/Demanda Relacionada</label>
                  <input type="text" class="data select form-control" id="tituloDemanda" style="margin-top: 18px;"
                    autocomplete="off" readonly>
                  <select class="form-control" name="idDemandaSelect" id="idDemandaSelect">
                    <?php
                    foreach ($demandas as $demanda) {
                      ?>
                    <option value="<?php echo $demanda['idDemanda'] ?>">
                      <?php echo $demanda['idDemanda'] . " - " . $demanda['tituloDemanda'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <input type="hidden" class="form-control" name="idTarefa" id="idTarefa" />
              <input type="hidden" class="form-control" name="idDemanda" id="idDemanda" />
              <div class="col-md-4" style="margin-top: -10px;">
                <div class="form-group">
                  <label class="labelForm">Cliente</label>
                  <input type="text" class="data select form-control" id="nomeCliente" style="margin-top: 18px;"
                    autocomplete="off" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class='control-label' for='inputNormal'>Reponsável</label>
                  <select class="form-control" name="idAtendente" id="idAtendente">
                    <?php
                    foreach ($atendentes as $atendente) {
                      ?>
                    <option value="<?php echo $atendente['idUsuario'] ?>">
                      <?php echo $atendente['nomeUsuario'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class='control-label' for='inputNormal'>Ocorrência</label>
                  <select class="form-control" name="idTipoOcorrencia" id="idTipoOcorrencia">
                    <?php
                    foreach ($ocorrencias as $ocorrencia) {
                      ?>
                    <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>">
                      <?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -14px;">
                <div class="form-group">
                  <label class="labelForm">Horas Cobrado</label>
                  <input type="time" class="data select form-control" id="horaCobrado" name="horaCobrado"
                    autocomplete="off">
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -30px;">
                <div class="form-group">
                  <label class="labelForm">Data Previsão</label>
                  <input type="date" class="data select form-control" id="Previsto" name="Previsto" autocomplete="off">
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -30px;">
                <div class="form-group">
                  <label class="labelForm">Inicio</label>
                  <input type="time" class="data select form-control" id="horaInicioPrevisto" name="horaInicioPrevisto"
                    autocomplete="off">
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -30px;">
                <div class="form-group">
                  <label class="labelForm">Fim</label>
                  <input type="time" class="data select form-control" id="horaFinalPrevisto" name="horaFinalPrevisto"
                    autocomplete="off">
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -30px;">
                <div class="form-group">
                  <label class="labelForm">Data Real</label>
                  <input type="date" class="data select form-control" id="dataReal" name="dataReal" autocomplete="off">
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -30px;">
                <div class="form-group">
                  <label class="labelForm">Inicio</label>
                  <input type="time" class="data select form-control" id="horaInicioReal" name="horaInicioReal"
                    autocomplete="off">
                </div>
              </div>
              <div class="col-md-4" style="margin-top: -30px;">
                <div class="form-group">
                  <label class="labelForm">Fim</label>
                  <input type="time" class="data select form-control" id="horaFinalReal" name="horaFinalReal"
                    autocomplete="off">
                </div>
              </div>
            </div>
            <div class="card-footer bg-transparent" style="text-align:right">
              <a id="visualizarDemandaButton" class="btn btn-primary" style="float:left">Visualizar</a>
              <button type="submit" class="btn btn-warning">Atualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script>
    buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    function limpar() {
      buscar(null, null, null, null, null, null, null, null, null, null);
      window.location.reload();
    }
    function limparPeriodo() {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), null, null, null, null, null);
      window.location.reload();
    }

    var vdata = new Date();

    var day = String(vdata.getDate()).padStart(2, '0');
    var month = String(vdata.getMonth() + 1).padStart(2, '0');
    var year = vdata.getFullYear();
    var today = `${day}/${month}/${year}`;

    var hh = String(vdata.getHours()).padStart(2, '0');
    var mm = String(vdata.getMinutes()).padStart(2, '0');
    var time = hh + ':' + mm;

    function buscar(idCliente, idAtendente, tituloTarefa, idTipoOcorrencia, statusTarefa, Periodo, PeriodoInicio, PeriodoFim, PrevistoOrdem, RealOrdem, buscaTarefa) {

      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '<?php echo URLROOT ?>/services/database/tarefas.php?operacao=filtrar',
        beforeSend: function () {
          $("#dados").html("Carregando...");
        },
        data: {
          idCliente: idCliente,
          idAtendente: idAtendente,
          tituloTarefa: tituloTarefa,
          idTipoOcorrencia: idTipoOcorrencia,
          statusTarefa: statusTarefa,
          Periodo: Periodo,
          PeriodoInicio: PeriodoInicio,
          PeriodoFim: PeriodoFim,
          PrevistoOrdem: PrevistoOrdem,
          RealOrdem: RealOrdem,
          buscaTarefa: buscaTarefa
        },
        success: function (msg) {

          var json = JSON.parse(msg);
          var linha = "";
          for (var $i = 0; $i < json.length; $i++) {
            var object = json[$i];

            function formatDate(dateString) {
              if (dateString !== null && !isNaN(new Date(dateString))) {
                var date = new Date(dateString);
                var day = date.getUTCDate().toString().padStart(2, '0');
                var month = (date.getUTCMonth() + 1).toString().padStart(2, '0');
                var year = date.getUTCFullYear().toString().padStart(4, '0');
                return day + "/" + month + "/" + year;
              }
              return "00/00/0000";
            }

            function formatTime(timeString) {
              if (timeString !== null) {
                var timeParts = timeString.split(':');
                var hours = timeParts[0].padStart(2, '0');
                var minutes = timeParts[1].padStart(2, '0');
                return hours + ":" + minutes;
              }
              return "00:00";
            }

            var vPrevisto = formatDate(object.Previsto);
            var vhoraInicioPrevisto = formatTime(object.horaInicioPrevisto);
            var vhoraFinalPrevisto = formatTime(object.horaFinalPrevisto);
            var vhorasPrevisto = formatTime(object.horasPrevisto);

            var vdataReal = formatDate(object.dataReal);
            var vhoraInicioReal = formatTime(object.horaInicioReal);
            var vhoraFinalReal = formatTime(object.horaFinalReal);
            var vhorasReal = formatTime(object.horasReal);
            var vhoraCobrado = formatTime(object.horaCobrado);

            linha += "<tr>";
            linha += "<td>" + object.idTarefa + "</td>";
            linha += "<td>";

            if (object.tituloTarefa == "") {
              linha += object.tituloDemanda;
            } else {
              linha += object.tituloTarefa;
            }

            linha += "</td>";
            linha += "<td>" + object.nomeUsuario + "</td>";
            linha += "<td>" + object.nomeCliente + "</td>";
            linha += "<td>" + object.nomeTipoOcorrencia + "</td>";
            linha += "<td>" + vPrevisto + " " + vhoraInicioPrevisto + " " + vhoraFinalPrevisto + " (" + vhorasPrevisto + ")" + "</td>";
            if (vhoraInicioReal != "00:00" && vhoraFinalReal == "00:00" && vdataReal == today) {
              var timeParts = time.split(':');
              var vhoraInicioRealParts = vhoraInicioReal.split(':');

              var timeMinutes = parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);
              var vhoraInicioRealMinutes = parseInt(vhoraInicioRealParts[0]) * 60 + parseInt(vhoraInicioRealParts[1]);

              var differenceMinutes = timeMinutes - vhoraInicioRealMinutes;

              var hours = Math.floor(differenceMinutes / 60);
              var minutes = differenceMinutes % 60;

              var vhorasReal = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');
            }
            linha += "<td>" + vdataReal + " " + vhoraInicioReal + " " + vhoraFinalReal + " (" + vhorasReal + ")" + "</td>";
            linha += "<td>" + vhoraCobrado + "</td>";
            linha += "<td class='text-center'>";
            if (vhoraInicioReal != "00:00" && vhoraFinalReal == "00:00" && vdataReal == today) {
              linha += "<button type='button' class='stopButton btn btn-danger btn-sm mr-1' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-data-execucao='" + object.horaInicioReal + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-stop-circle'></i></button>"
            }
            if (vhoraInicioReal == "00:00") {
              linha += "<button type='button' class='startButton btn btn-success btn-sm mr-1' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-play-circle'></i></button>"
              linha += "<button type='button' class='realizadoButton btn btn-info btn-sm mr-1' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-check-circle'></i></button>"
            }
            linha += "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#alterarmodal' data-idtarefa='" + object.idTarefa + "'><i class='bi bi-pencil-square'></i></button>"

            linha += "</td>";
            linha += "</tr>";
          }
          $("#dados").html(linha);
        }
      });
    }

    $("#FiltroClientes").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroUsuario").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#buscar").click(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroOcorrencia").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroDemanda").click(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroStatusTarefa").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
      window.location.reload();
    });

    $("#FiltroPrevistoOrdem").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroRealOrdem").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#filtrarButton").click(function () {
      if (!$('#PrevisaoRadio').is(':checked') && !$('#RealizadoRadio').is(':checked')) {
        alert("Por favor selecione uma opção.");
        return false;
      } else {
        buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
        $('#periodoModal').modal('hide');
        window.location.reload();
      }
    });

    document.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#tituloDemanda").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
      }
    });

    $(document).on('click', 'button[data-target="#alterarmodal"]', function () {
      var idTarefa = $(this).attr("data-idtarefa");
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '<?php echo URLROOT ?>/services/database/tarefas.php?operacao=buscar',
        data: {
          idTarefa: idTarefa
        },
        success: function (data) {
          $('#idTarefa').val(data.idTarefa);
          $('#titulo').val(data.tituloTarefa);
          $('#idCliente').val(data.idCliente);
          $('#nomeCliente').val(data.nomeCliente);
          $('#idDemanda').val(data.idDemanda);
          $('#idDemandaSelect').val(data.idDemanda);
          $('#tituloDemanda').val(data.idDemanda + ' - ' + data.tituloDemanda);
          $('#idAtendente').val(data.idAtendente);
          $('#nomeUsuario').val(data.nomeUsuario);
          $('#idTipoOcorrencia').val(data.idTipoOcorrencia);
          $('#nomeTipoOcorrencia').val(data.nomeTipoOcorrencia);
          $('#Previsto').val(data.Previsto);
          $('#horaInicioPrevisto').val(data.horaInicioPrevisto);
          $('#horaFinalPrevisto').val(data.horaFinalPrevisto);
          $('#dataReal').val(data.dataReal);
          $('#horaInicioReal').val(data.horaInicioReal);
          $('#horaFinalReal').val(data.horaFinalReal);
          $('#horaCobrado').val(data.horaCobrado);

          if (data.idDemanda !== null) {
            var visualizarDemandaUrl = "visualizar.php?idDemanda=" + data.idDemanda;
            $("#visualizarDemandaButton").attr("href", visualizarDemandaUrl);
            $('#visualizarDemandaButton').show();
          } else {
            $('#visualizarDemandaButton').hide();
          }

          if (data.idDemanda !== null) {
            $('#idDemandaSelect').hide();
            $('#tituloDemanda').show();
          } else {
            $('#idDemandaSelect').show();
            $('#tituloDemanda').hide();
          }

          $('#alterarmodal').modal('show');
        }
      });
    });

    $('.btnAbre').click(function () {
      $('.menuFiltros').toggleClass('mostra');
      $('.diviFrame').toggleClass('mostra');
    });



    var inserirModal = document.getElementById("inserirModal");

    var inserirBtn = document.querySelector("button[data-target='#inserirModal']");

    inserirBtn.onclick = function () {
      inserirModal.style.display = "block";
    };

    window.onclick = function (event) {
      if (event.target == inserirModal) {
        inserirModal.style.display = "none";
      }
    };

    $(document).on('click', '.stopButton', function () {
      var idTarefa = $(this).data('id');
      var tipoStatusDemanda = $(this).data('status');
      var horaInicioCobrado = $(this).data('data-execucao');
      var idDemanda = $(this).data('demanda');
      $.ajax({
        url: "../database/tarefas.php?operacao=stop",
        method: "POST",
        dataType: "json",
        data: {
          idTarefa: idTarefa,
          tipoStatusDemanda: tipoStatusDemanda,
          horaInicioCobrado: horaInicioCobrado,
          idDemanda: idDemanda
        },
        success: function (msg) {
          if (msg.retorno == "ok") {
            window.location.reload();
          }
        }
      });
    });

    $(document).on('click', '.startButton', function () {
      var idTarefa = $(this).data('id');
      var tipoStatusDemanda = $(this).data('status');
      var idDemanda = $(this).data('demanda');
      $.ajax({
        url: "../database/tarefas.php?operacao=start",
        method: "POST",
        dataType: "json",
        data: {
          idTarefa: idTarefa,
          tipoStatusDemanda: tipoStatusDemanda,
          idDemanda: idDemanda
        },
        success: function (msg) {
          if (msg.retorno == "ok") {
            window.location.reload();
          }
        }
      });
    });

    $(document).on('click', '.realizadoButton', function () {
      var idTarefa = $(this).data('id');
      var tipoStatusDemanda = $(this).data('status');
      var idDemanda = $(this).data('demanda');
      $.ajax({
        url: "../database/tarefas.php?operacao=realizado",
        method: "POST",
        dataType: "json",
        data: {
          idTarefa: idTarefa,
          tipoStatusDemanda: tipoStatusDemanda,
          idDemanda: idDemanda
        },
        success: function (msg) {
          if (msg.retorno == "ok") {
            window.location.reload();
          }
        }
      });
    });

    $(document).ready(function () {
      $("#inserirForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
          url: "../database/tarefas.php?operacao=inserir",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: refreshPage,
        });
      });

      $("#alterarForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
          url: "../database/tarefas.php?operacao=alterar",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: refreshPage,
        });
      });
      function refreshPage() {
        window.location.reload();
      }
    });

    //Gabriel 22092023 id544 trocado setcookie por httpRequest enviado para gravar origem em session//ajax
    $("#visualizarDemandaButton").click(function() {
      var currentPath = window.location.pathname;
      $.ajax({
        type: 'POST',
        url: '../database/demanda.php?operacao=origem',
        data: { origem: currentPath },
        success: function(response) {
          console.log('Session variable set successfully.');
        },
        error: function(xhr, status, error) {
          console.error('An error occurred:', error);
        }
      });
    });

  </script>


</body>

</html>