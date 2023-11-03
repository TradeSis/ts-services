<?php
// Lucas 17102023 novo padrao
//Gabriel 06102023 ID 596 mudanças em agenda e tarefas 
//lucas 25092023 ID 358 Demandas/Comentarios
// Gabriel 22092023 id 544 Demandas - Botão Voltar
// gabriel 04082023


include_once(__DIR__ . '/../header.php');
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
<!doctype html>
<html lang="pt-BR">

<head>

  <?php include_once ROOT . "/vendor/head_css.php"; ?>
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

</head>


<body>

  <div class="container-fluid">

    <div class="row">
      <!--<BR>  MENSAGENS/ALERTAS -->
    </div>
    <div class="row mt-3">
       <!-- <BR><BR><BR> BOTOES AUXILIARES -->
    </div>

    <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

      <div class="col-2 col-lg-1 order-lg-1">
        <button class="btn btn-outline-secondary ts-btnFiltros" type="button"><i class="bi bi-funnel"></i></button>
      </div>

      <div class="col-4 col-lg-3 order-lg-2" id="filtroh6">
        <h2 class="ts-tituloPrincipal">Tarefas</h2>
        <h6 style="font-size: 10px;font-style:italic;text-align:left;"></h6>
      </div>

      <div class="col-6 col-lg-2 order-lg-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periodoModal"><i class="bi bi-calendar3"></i></button>
      </div>

      <div class="col-12 col-lg-6 order-lg-4">
        <div class="input-group">
          <input type="text" class="form-control ts-input" id="buscaTarefa" placeholder="Buscar por id ou titulo">
          <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
          <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
        </div>
      </div>

    </div>

    <!-- MENUFILTROS -->
    <div class="ts-menuFiltros mt-2 px-3">
      <label>Filtrar por:</label>

      <!-- Gabriel 06102023 ID 596 ajustado posiçao -->
      <div class="ls-label col-sm-12"> <!-- ABERTO/FECHADO -->
        <form class="d-flex" action="" method="post">
          <select class="form-control" name="statusTarefa" id="FiltroStatusTarefa">
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
      </div>

      <div class="col-sm text-end mt-2">
        <a onClick="limpar()" role=" button" class="btn btn-sm bg-info text-white">Limpar</a>
      </div>
    </div>

    <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
      <table class="table table-sm table-hover">
        <thead class="ts-headertabelafixo">
          <tr class="ts-headerTabelaLinhaCima">
            <th>ID</th>
            <th>Tarefa</th>
            <th>Responsável</th>
            <th>Cliente</th>
            <th>Ocorrência</th>
            <th>Datas</th>
            <th>Cobrado</th>
            <th colspan="2">Ação</th>
          </tr>
          <tr class="ts-headerTabelaLinhaBaixo">
            <th></th>
            <th></th>
            <th>
              <form action="" method="post">
                <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idAtendente" id="FiltroUsuario">
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
            <th>
              <form action="" method="post">
                <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idCliente" id="FiltroClientes">
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
            <th>
              <form action="" method="post">
                <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idTipoOcorrencia" id="FiltroOcorrencia">
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
            <!-- <th>
              <form action="" method="post">
                <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="PrevistoOrdem" null              <option value="<?php echo null ?>">
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
            </th> -->
            <!-- <th>
              <form action="" method="post">
                <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="RealOrdem" id="FiltroRealOrdem">
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
            </th> -->
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>

        <tbody id='dados' class="fonteCorpo">

        </tbody>
      </table>
    </div>

  </div>


  <!--------- FILTRO PERIODO --------->
  <?php include_once 'modalTarefa_filtroPeriodo.php' ?>

  <!--------- MODAL STOP Tab EXECUCAO --------->
  <?php include_once 'modalTarefa_stop.php' ?>

  <!--------- INSERIR/AGENDAR --------->
  <?php include_once 'modalTarefa_inserirAgendar.php' ?>

  <!--------- TAREFAS ALTERAR--------->
  <?php include 'modalTarefa_alterar.php'; ?>



  <!-- LOCAL PARA COLOCAR OS JS -->

  <?php include_once ROOT . "/vendor/footer_js.php"; ?>
  <!-- script para menu de filtros -->
  <script src="<?php echo URLROOT ?>/sistema/js/filtroTabela.js"></script>
  <!-- QUILL editor -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

  <script>
    buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), null , null , $("#buscaTarefa").val());

    function limpar() {
      buscar(null, null, null, null, null, null, null, null, null, null, function() {
        //gabriel 13102023 id 596 fix atualizar pagina correta
        window.location.reload();
      });
    }

    function limparPeriodo() {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), null, null, null, null, null, function() {
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
      var h6Element = $("#filtroh6 h6");
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
        beforeSend: function() {
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
        success: function(msg) {

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
              if(vdataReal === "00/00/0000"){
                linha += "<td style='background:firebrick;color:white'>" + "Previsto: " + vPrevisto + " " + vhoraInicioPrevisto + " " + vhoraFinalPrevisto + " (" + vhorasPrevisto + ")" + "<br>" + "<p></p>" + "</td>";
              }
              else{
                linha += "<td style='background:firebrick;color:white'>" + "Previsto: " + vPrevisto + " " + vhoraInicioPrevisto + " " + vhoraFinalPrevisto + " (" + vhorasPrevisto + ")" + "<br>" + "Real: " + vdataReal + " " + vhoraInicioReal + " " + vhoraFinalReal + " (" + vhorasReal + ")"  + "</td>";

              }
              
            } else {
              if(vPrevisto === "00/00/0000"){
                linha += "<td>" + "Real: " + vdataReal + " " + vhoraInicioReal + " " + vhoraFinalReal + " (" + vhorasReal + ")"  + "<p></p>" + "</td>";

              }else{
              linha += "<td>" + "Previsto: " + vPrevisto + " " + vhoraInicioPrevisto + " " + vhoraFinalPrevisto + " (" + vhorasPrevisto + ")" + "<br>" + "Real: " + vdataReal + " " + vhoraInicioReal + " " + vhoraFinalReal + " (" + vhorasReal + ")"  + "</td>";
              }
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
            /* linha += "<td>" + vdataReal + " " + vhoraInicioReal + " " + vhoraFinalReal + " (" + vhorasReal + ")" + "</td>"; */
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
            linha += "<button type='button' class='clonarButton btn btn-success btn-sm mr-1'  data-idtarefa='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-back'></i></button>";
            linha += "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarmodal' data-idtarefa='" + object.idTarefa + "'><i class='bi bi-pencil-square'></i></button>"

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

    $("#FiltroClientes").change(function() {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroUsuario").change(function() {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#buscar").click(function() {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroOcorrencia").change(function() {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroDemanda").click(function() {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroStatusTarefa").change(function() {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroPrevistoOrdem").change(function() {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroRealOrdem").change(function() {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    //Gabriel 11102023 ID 596 adicionado document ready pois o modal está em indextarefa.php
    $(document).ready(function() {
      $("#filtrarButton").click(function() {
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

    document.addEventListener("keypress", function(e) {
      if (e.key === "Enter") {
        //Gabriel 06102023 ID 596 ajustado #buscaTarefa
        buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
      }
    });


    //lucas 25092023 ID 358 Adicionado script para popup de stop
    $(document).on('click', 'button[data-target="#stopexecucaomodal"]', function() {
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
        success: function(data) {
          $('#idTarefa-stopexecucao').val(data.idTarefa);
          $('#idDemanda-stopexecucao').val(idDemanda);
          $('#status-stopexecucao').val(status);
          $('#horaInicioReal-stopexecucao').val(horaInicioReal);

          $('#stopexecucaomodal').modal('show');
        }
      });
    });


    var inserirModal = document.getElementById("inserirModal");

    var inserirBtn = document.querySelector("button[data-bs-target='#inserirModal']");

    inserirBtn.onclick = function() {
      inserirModal.style.display = "block";
    };

    window.onclick = function(event) {
      if (event.target == inserirModal) {
        inserirModal.style.display = "none";
      }
    };

    $(document).ready(function() {
      $(document).on('click', 'button.clonarButton', function() {

        var idTarefa = $(this).data("idtarefa"); // Use data() to access the custom data attribute
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: '<?php echo URLROOT ?>/services/database/tarefas.php?operacao=buscar',
          data: {
            idTarefa: idTarefa
          },
          success: function(data) {
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



    $(document).on('click', '.stopButton', function() {
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
        success: function(msg) {
          if (msg.retorno == "ok") {
            window.location.reload();
          }
        }
      });
    });

    $(document).on('click', '.startButton', function() {
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
        success: function(msg) {
          if (msg.retorno == "ok") {
            window.location.reload();
          }
        }
      });
    });

    $(document).on('click', '.realizadoButton', function() {
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
        success: function(msg) {
          if (msg.retorno == "ok") {
            window.location.reload();
          }
        }
      });
    });

    $(document).ready(function() {
      $("#inserirForm").submit(function(event) {
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

      $("#inserirStartBtn").click(function() {
        $("#inserirBtn").prop("clicked", false);
        $(this).prop("clicked", true);
      });

      $("#inserirBtn").click(function() {
        $("#inserirStartBtn").prop("clicked", false);
        $(this).prop("clicked", true);
      });

      $("#alterarForm").submit(function(event) {
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
      $("#stopForm").submit(function(event) {
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
    $("#visualizarDemandaButton").click(function() {
      var currentPath = window.location.pathname;
      $.ajax({
        type: 'POST',
        url: '../database/demanda.php?operacao=origem',
        data: {
          origem: currentPath
        },
        success: function(response) {
          console.log('Session variable set successfully.');
        },
        error: function(xhr, status, error) {
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
    quillstop.on('text-change', function(delta, oldDelta, source) {
      $('#quill-stop').val(quillstop.container.firstChild.innerHTML);
    });
  </script>


  <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>