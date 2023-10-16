<?php
//Gabriel 06102023 ID 596 mudanças em agenda e tarefas 
//lucas 25092023 ID 358 Demandas/Comentarios
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
//lucas 25092023 ID 358 Adicionado buscaUsuarios
$usuario = buscaUsuarios(null, $_SESSION['idLogin']);

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

<style>
  .nav-link {
        display: inline-block;
        padding: 5px 10px;
        cursor: pointer;
        position: relative;
        z-index: 5;
        border-radius: 3px 3px 0 0;
        background-color: #567381;
        color: #EEEEEE;
    }
    .nav-link .active {
        border: 1px solid #707070;
        border-bottom: 1px solid #fff;
        border-radius: 3px 3px 0 0;
        background-color: #EEEEEE;
        color: #567381;
    }
</style>

<body class="bg-transparent">

  <nav id="menuFiltros" class="menuFiltros" style="width: 163px;margin-top:-58px;margin-left:40px">
    <div class="titulo"><span>Filtrar por:</span></div>
    <ul>
      <!-- Gabriel 06102023 ID 596 ajustado posiçao -->
      <li class="ls-label col-sm-12 mr-1" style="list-style-type: none;"> <!-- ABERTO/FECHADO -->
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


  <div class="container-fluid text-center mt-2">

    <div class="row">
      <div class="btnAbre" style="height:33px">
        <span style="font-size: 25px;font-family: 'Material Symbols Outlined'!important;"
          class="material-symbols-outlined">
          filter_alt
        </span>

      </div>

      <div class="col-sm-3 ml-2">
        <h2 class="tituloTabela">Tarefas</h2>
        <!-- Gabriel 11102023 ID 596 removido, h6 agora preenche via script -->
        <h6 style="font-size: 10px;font-style:italic;text-align:left;"></h6>
      </div>

      <!-- Gabriel 06102023 ID 596 removido buscar duplicado -->
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


  <!--------- MODAL STOP Tab EXECUCAO --------->
  <div class="modal fade bd-example-modal-lg" id="stopexecucaomodal" tabindex="-1" role="dialog"
    aria-labelledby="stopexecucaomodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stop Tarefa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- gabriel 13102023 id 596 adicionado id -->
          <form method="post" id="stopForm">
            <div class="container-fluid p-0">
              <div class="col">
                <span class="tituloEditor">Comentários</span>
              </div>
              <div class="quill-stop" style="height:20vh !important"></div>
              <textarea style="display: none" id="quill-stop" name="comentario"></textarea>
            </div>
            <div class="col-md form-group" style="margin-top: 5px;">
              <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>"
                readonly>
              <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>"
                readonly>
              <input type="hidden" class="form-control" name="idTarefa" id="idTarefa-stopexecucao" />
              <input type="hidden" class="form-control" name="idDemanda" id="idDemanda-stopexecucao" />
              <input type="hidden" class="form-control" name="tipoStatusDemanda" id="status-stopexecucao" />
              <input type="time" class="form-control" name="horaInicioCobrado" id="horaInicioReal-stopexecucao" step="2"
                readonly style="display: none;" />

            </div>
        </div>
        <div class="modal-footer">
          <div class="col align-self-start pl-0">
            <!-- gabriel 13102023 id 596 fix ao dar stop vai para demanda -->
            <button type="submit" id="realizadoFormbutton" class="btn btn-warning float-left">Entregar</button>
          </div>
          <!-- gabriel 13102023 id 596 fix ao dar stop vai para demanda -->
          <button type="submit" id="stopFormbutton" class="btn btn-danger">Stop</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--------- INSERIR/AGENDAR --------->
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
                <div class="for-group" style="margin-top: 22px;">
                  <input type="text" class="form-control" name="tituloTarefa" id="newtitulo" autocomplete="off"
                    required>
                </div>
                <input type="hidden" class="form-control" name="idDemanda" value="null" id="newidDemanda">
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class='control-label' for='inputNormal'>Cliente</label>
                  <div class="form-group" style="margin-top: 40px;">
                    <select class="form-control" name="idCliente" id="newidCliente">
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
              <div class="col-md-6">
                <div class="form-group">
                  <label class='control-label' for='inputNormal'>Reponsável</label>
                  <div class="form-group" style="margin-top: 20px;">
                    <select class="form-control" name="idAtendente" id="newidAtendente">
                      <!-- gabriel 13102023 id596 removido a possibilidade de adicionar tarefa sem responsável -->
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
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class='control-label' for='inputNormal'>Ocorrência</label>
                  <div class="form-group" style="margin-top: 20px;">
                    <select class="form-control" name="idTipoOcorrencia" id="newidTipoOcorrencia">
                      <option value="null">Selecione</option>
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
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="labelForm">Data Previsão</label>
                  <input type="date" class="data select form-control" name="Previsto" autocomplete="off" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="labelForm">Inicio</label>
                  <input type="time" class="data select form-control" name="horaInicioPrevisto" autocomplete="off">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="labelForm">Fim</label>
                  <input type="time" class="data select form-control" name="horaFinalPrevisto" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="card-footer bg-transparent" style="text-align:right">
              <button type="submit" class="btn btn-warning" id="inserirStartBtn">Start</button>
              <button type="submit" class="btn btn-success" id="inserirBtn">Inserir</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include 'alterarTarefaModal.php'; ?>

  <script>
    buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    function limpar() {
      buscar(null, null, null, null, null, null, null, null, null, null, function () {
      //gabriel 13102023 id 596 fix atualizar pagina correta
      refreshTab('execucao');
      });
    }
    function limparPeriodo() {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), null, null, null, null, null, function () {
        window.location.reload();
      });
    }
    //Gabriel 06102023 ID 596 movido function do ajax para ser utilizado fora dele
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

    var vdata = new Date();

    var day = String(vdata.getDate()).padStart(2, '0');
    var month = String(vdata.getMonth() + 1).padStart(2, '0');
    var year = vdata.getFullYear();
    var today = `${day}/${month}/${year}`;

    var hh = String(vdata.getHours()).padStart(2, '0');
    var mm = String(vdata.getMinutes()).padStart(2, '0');
    var time = hh + ':' + mm;

    //Gabriel 16102023 id596 variavel dia/hora 
    var todayTime = today + " " + time;

    function buscar(idCliente, idAtendente, tituloTarefa, idTipoOcorrencia, statusTarefa, Periodo, PeriodoInicio, PeriodoFim, PrevistoOrdem, RealOrdem, buscaTarefa, callback) {
      //Gabriel 11102023 ID 596 utiliza valores do buscar para gravar no h6 da tabela filtros status e periodo
      var h6Element = $(".col-sm-3 h6");
      var text = "";
      if (statusTarefa === "1") {
        if (text) text += ", ";
        text += "Status = Aberto";
      } else if (statusTarefa === "0") {
        if (text) text += ", ";
        text += "Status = Realizado";
      }
      if (Periodo === "1") {
        if (text) text += ", ";
        text += "Periodo = Previsão";
      } else if (Periodo === "0") {
        if (text) text += ", ";
        text += "Periodo = Realizado";
      }
      if (PeriodoInicio !== "") {
        if (text) text += " em ";
        text += formatDate(PeriodoInicio);
      }
      if (PeriodoFim !== "") {
        if (text) text += " até ";
        text += formatDate(PeriodoFim);
      }

      h6Element.html(text);
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


            var vPrevisto = formatDate(object.Previsto);
            var vhoraInicioPrevisto = formatTime(object.horaInicioPrevisto);
            var vhoraFinalPrevisto = formatTime(object.horaFinalPrevisto);
            var vhorasPrevisto = formatTime(object.horasPrevisto);
            //Gabriel 16102023 id596 ajustando if
            var vhoraInicioPrevistoTime = vhoraInicioPrevisto.split(":");
            var vhoraInicioPrevistoMinutes = parseInt(vhoraInicioPrevistoTime[0]) * 60 + parseInt(vhoraInicioPrevistoTime[1]);
            var timeTime = time.split(":");
            var timeMinutes = parseInt(timeTime[0]) * 60 + parseInt(timeTime[1]);
           

            var vdataReal = formatDate(object.dataReal);
            var vhoraInicioReal = formatTime(object.horaInicioReal);
            var vhoraFinalReal = formatTime(object.horaFinalReal);
            var vhorasReal = formatTime(object.horasReal);
            var vhoraCobrado = formatTime(object.horaCobrado);
            linha += "<tr>";
            linha += "<td>" + object.idTarefa + "</td>";
            linha += "<td data-target='#alterarmodal' data-idtarefa='" + object.idTarefa + "'>";

            if (object.tituloTarefa == "") {
              linha += object.tituloDemanda;
            } else {
              linha += object.tituloTarefa;
            }

            linha += "</td>";
            linha += "<td>" + object.nomeUsuario + "</td>";
            linha += "<td>" + object.nomeCliente + "</td>";
            linha += "<td>" + object.nomeTipoOcorrencia + "</td>";
            //Gabriel 16102023 id596 ajustando if
            if (
                (vPrevisto < today || (vPrevisto === today && vhoraInicioPrevistoMinutes > 0 && vhoraInicioPrevistoMinutes < timeMinutes)) &&
                vdataReal === "00/00/0000" &&
                vPrevisto !== "00/00/0000"
              ) {
              linha += "<td style='background:firebrick'>" + vPrevisto + " " + vhoraInicioPrevisto + " " + vhoraFinalPrevisto + " (" + vhorasPrevisto + ")" + "</td>";
            } else {
              linha += "<td>" + vPrevisto + " " + vhoraInicioPrevisto + " " + vhoraFinalPrevisto + " (" + vhorasPrevisto + ")" + "</td>";
            }
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
            linha += "<td class='text-center' id='botao'>";
            if (vhoraInicioReal != "00:00" && vhoraFinalReal == "00:00" && vdataReal == today) {
              //lucas 25092023 ID 358 Adicionado condição para botão com demanda associada e sem demanda asssociada
              if (object.idDemanda == null) {
                linha += "<button type='button' class='stopButton btn btn-danger btn-sm mr-1' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-data-execucao='" + object.horaInicioReal + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-stop-circle'></i></button>"
              } else {
                linha += "<button type='button' class='btn btn-danger btn-sm mr-1' data-toggle='modal' data-target='#stopexecucaomodal' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-data-execucao='" + object.horaInicioReal + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-stop-circle'></i></button>"
              }
            }
            if (vhoraInicioReal == "00:00") {
              linha += "<button type='button' class='startButton btn btn-success btn-sm mr-1' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-play-circle'></i></button>"
              linha += "<button type='button' class='realizadoButton btn btn-info btn-sm mr-1' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-check-circle'></i></button>"
            }
            linha += "<button type='button' class='clonarButton btn btn-success btn-sm mr-1' data-idtarefa='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-back'></i></button>";
            linha += "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#alterarmodal' data-idtarefa='" + object.idTarefa + "'><i class='bi bi-pencil-square'></i></button>"

            linha += "</td>";
            linha += "</tr>";
          }

          $("#dados").html(linha);

          if (typeof callback === 'function') {
            callback();
          }
        }
      });
    }

    $("#FiltroClientes").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroUsuario").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#buscar").click(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroOcorrencia").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroDemanda").click(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroStatusTarefa").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroPrevistoOrdem").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroRealOrdem").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    //Gabriel 11102023 ID 596 adicionado document ready pois o modal está em indextarefa.php
    $(document).ready(function () {
      $("#filtrarButton").click(function () {
        if (!$('#PrevisaoRadio').is(':checked') && !$('#RealizadoRadio').is(':checked')) {
          alert("Por favor selecione uma opção.");
          return false;
        } else {
          //Gabriel 06102023 ID 596 ajustado #buscaTarefa
          buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
          $('#periodoModal').modal('hide');
        }
      });
    });

    document.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        //Gabriel 06102023 ID 596 ajustado #buscaTarefa
        buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
      }
    });


    //lucas 25092023 ID 358 Adicionado script para popup de stop
    $(document).on('click', 'button[data-target="#stopexecucaomodal"]', function () {
      var idTarefa = $(this).attr("data-id");
      var idDemanda = $(this).attr("data-demanda");
      var status = $(this).attr("data-status");
      var horaInicioReal = $(this).attr("data-data-execucao");

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '<?php echo URLROOT ?>/services/database/tarefas.php?operacao=buscar',
        data: {
          idTarefa: idTarefa
        },
        success: function (data) {
          $('#idTarefa-stopexecucao').val(data.idTarefa);
          $('#idDemanda-stopexecucao').val(idDemanda);
          $('#status-stopexecucao').val(status);
          $('#horaInicioReal-stopexecucao').val(horaInicioReal);

          $('#stopexecucaomodal').modal('show');
        }
      });
    });

    $('.btnAbre').click(function () {
      //Gabriel 06102023 ID 596 ajustado para ID ao invés de classe
      $('#menuFiltros').toggleClass('mostra');
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

    $(document).ready(function () {
      $(document).on('click', 'button.clonarButton', function () {
        var idTarefa = $(this).data("idtarefa"); // Use data() to access the custom data attribute
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: '<?php echo URLROOT ?>/services/database/tarefas.php?operacao=buscar',
          data: {
            idTarefa: idTarefa
          },
          success: function (data) {
            $('#newtitulo').val(data.tituloTarefa);
            $('#newidCliente').val(data.idCliente);
            $('#newidDemanda').val(data.idDemanda);
            $('#newidAtendente').val(data.idAtendente);
            $('#newidTipoOcorrencia').val(data.idTipoOcorrencia);
            $('#newtipoStatusDemanda').val(data.idTipoStatus);
            $('#newdescricao').val(data.descricao);

            $('#inserirModal').modal('show');
          }
        });
      });
    });



    $(document).on('click', '.stopButton', function () {
      var idTarefa = $(this).data('id');
      var tipoStatusDemanda = $(this).data('status');
      var horaInicioCobrado = $(this).data('data-execucao');
      var idDemanda = $(this).data('demanda');
      $.ajax({
        //lucas 25092023 ID 358 Modificado operação de tarefas
        url: "../database/tarefas.php?operacao=stopsemdemanda",
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
        var vurl;
        if ($("#inserirStartBtn").prop("clicked")) {
          vurl = "../database/tarefas.php?operacao=inserirStart";
        } else {
          vurl = "../database/tarefas.php?operacao=inserir";
        }
        $.ajax({
          url: vurl,
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          //gabriel 13102023 id 596 fix atualizar pagina correta
          success: refreshPage
        });
      });

      $("#inserirStartBtn").click(function () {
        $("#inserirBtn").prop("clicked", false);
        $(this).prop("clicked", true);
      });

      $("#inserirBtn").click(function () {
        $("#inserirStartBtn").prop("clicked", false);
        $(this).prop("clicked", true);
      });

      $("#alterarForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }
        var vurl;
        if ($("#stopButtonModal").is(":focus")) {
          vurl = "../database/tarefas.php?operacao=stop";
        }
        if ($("#startButtonModal").is(":focus")) {
          vurl = "../database/tarefas.php?operacao=start";
        }
        if ($("#realizadoButtonModal").is(":focus")) {
          vurl = "../database/tarefas.php?operacao=realizado";
        }
        if ($("#atualizarButtonModal").is(":focus")) {
          vurl = "../database/tarefas.php?operacao=alterar";
        }
        $.ajax({
          url: vurl,
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: refreshPage

        });
      });
      function refreshPage() {
        window.location.reload();
      }

      //gabriel 13102023 id 596 submit stopForm para evitar redirecionamento para demanda
      $("#stopForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }
        var vurl;
        if ($("#realizadoFormbutton").is(":focus")) {
          vurl = "../database/demanda.php?operacao=realizado";
        }
        if ($("#stopFormbutton").is(":focus")) {
          vurl = "../database/tarefas.php?operacao=stop";
        }
        $.ajax({
          url: vurl,
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: refreshPage
        });
      });
    });


    //Gabriel 22092023 id544 trocado setcookie por httpRequest enviado para gravar origem em session//ajax
    $("#visualizarDemandaButton").click(function () {
      var currentPath = window.location.pathname;
      $.ajax({
        type: 'POST',
        url: '../database/demanda.php?operacao=origem',
        data: { origem: currentPath },
        success: function (response) {
          console.log('Session variable set successfully.');
        },
        error: function (xhr, status, error) {
          console.error('An error occurred:', error);
        }
      });
    });



    var quillstop = new Quill('.quill-stop', {
      theme: 'snow',
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline', 'strike'],
          ['blockquote'],
          [{
            'list': 'ordered'
          }, {
            'list': 'bullet'
          }],
          [{
            'indent': '-1'
          }, {
            'indent': '+1'
          }],
          [{
            'direction': 'rtl'
          }],
          [{
            'size': ['small', false, 'large', 'huge']
          }],
          [{
            'header': [1, 2, 3, 4, 5, 6, false]
          }],
          ['link', 'image', 'video', 'formula'],
          [{
            'color': []
          }, {
            'background': []
          }],
          [{
            'font': []
          }],
          [{
            'align': []
          }],
        ]
      }
    });

    /* lucas 22092023 ID 358 Modificado nome da classe do editor */
    quillstop.on('text-change', function (delta, oldDelta, source) {
      $('#quill-stop').val(quillstop.container.firstChild.innerHTML);
    });

  </script>

</body>

</html>