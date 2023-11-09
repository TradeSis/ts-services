<?php
// lucas 31102023 id650/erros
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/demanda.php');
include_once(ROOT . '/cadastros/database/clientes.php');
include_once(ROOT . '/cadastros/database/usuario.php');
include_once(__DIR__ . '/../database/tipostatus.php');
include_once(__DIR__ . '/../database/tipoocorrencia.php');
include_once '../database/contratotipos.php';
include_once '../database/contratos.php';
include_once(ROOT . '/cadastros/database/servicos.php');

$urlContratoTipo = null;
if (isset($_GET["tipo"])) {
  $urlContratoTipo = $_GET["tipo"];
  $contratoTipo = buscaContratoTipos($urlContratoTipo);
} else {
  $contratoTipo = buscaContratoTipos('contratos');
}
$ClienteSession = null;
if (isset($_SESSION['idCliente'])) {
  $ClienteSession = $_SESSION['idCliente'];
}

$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
$clientes = buscaClientes();
$atendentes = buscaAtendente();
$usuarios = buscaUsuarios();
$tiposstatus = buscaTipoStatus();
$tipoocorrencias = buscaTipoOcorrencia();
$cards = buscaCardsDemanda();
$contratos = buscaContratosAbertos();
$servicos = buscaServicos();

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
$statusDemanda = "1"; //ABERTO

$filtroEntrada = null;
$idTipoStatus = null;
$idTipoOcorrencia = null;
$idSolicitante = null;


if (isset($_SESSION['filtro_demanda'])) {
  $filtroEntrada = $_SESSION['filtro_demanda'];
  $idCliente = $filtroEntrada['idCliente'];
  $idSolicitante = $filtroEntrada['idSolicitante'];
  $idAtendente = $filtroEntrada['idAtendente'];
  $idTipoStatus = $filtroEntrada['idTipoStatus'];
  $idTipoOcorrencia = $filtroEntrada['idTipoOcorrencia'];
  $statusDemanda = $filtroEntrada['statusDemanda'];
  $posicao = $filtroEntrada['posicao'];
}
?>

<!doctype html>
<html lang="pt-BR">

<head>

  <?php include_once ROOT . "/vendor/head_css.php"; ?>
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>

table tr:hover{cursor:pointer;}

</style>

</head>

<body>
  <div class="container-fluid">

    <div class="row">
      <!-- <BR> MENSAGENS/ALERTAS -->
    </div>

    <div class="row row-cols-1 row-cols-md-5 pt-2">
      <!-- BOTOES AUXILIARES -->
      <div class="col">
        <div class="ts-cardColor card border-left-success ts-shadowOff ts-cardsTotais p-1">
          <div class="text-xs fw-bold text-success">TODOS</div>
          <div class="h5 mb-0  text-gray-800 ml-1">
            <?php echo $cards['totalDemandas'] ?>
          </div>
          <button class="ts-cardLink" onClick="clickCard(this.value)" value="" id=""></button>
        </div>
      </div>

      <div class="col">
        <div class="ts-cardColor1 ts-cardColor-active card border-left-success  ts-cardsTotais p-1">
          <div class="text-xs fw-bold text-primary">ABERTO</div>
          <div class="h5 mb-0  text-gray-800 ml-1">
            <?php echo $cards['totalAbertas'] ?>
          </div>
          <button class="ts-cardLink" onClick="clickCard(this.value)" value="1" id="1"></button>
        </div>
      </div>

      <div class="col">
        <div class="ts-cardColor2 card border-left-success ts-shadowOff ts-cardsTotais p-1">
          <div class="text-xs fw-bold text-info">EXECUÇÃO</div>
          <div class="h5 mb-0  text-gray-800 ml-1">
            <?php echo $cards['totalExecucao'] ?>
          </div>
          <button class="ts-cardLink" onClick="clickCard(this.value)" value="2" id="2"></button>
        </div>
      </div>

      <div class="col">
        <div class="ts-cardColor3 card border-left-success ts-shadowOff ts-cardsTotais p-1">
          <div class="text-xs fw-bold text-warning">ENTREGUE</div>
          <div class="h5 mb-0  text-gray-800 ml-1">
            <?php echo $cards['totalEntregue'] ?>
          </div>
          <button class="ts-cardLink" onClick="clickCard(this.value)" value="3" id="3"></button>
        </div>
      </div>

      <div class="col">
        <div class="ts-cardColor0 card border-left-success ts-shadowOff ts-cardsTotais p-1">
          <div class="text-xs fw-bold text-danger pl-4">FECHADO</div>
          <div class="h5 mb-0  text-gray-800 ml-1">
            <?php echo $cards['totalFechado'] ?>
          </div>
          <button class="ts-cardLink" onClick="clickCard(this.value)" value="0" id="0"></button>
        </div>
      </div>

    </div> <!-- fim- BOTOES AUXILIARES -->

    <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

      <div class="col-2 col-lg-1 order-lg-1">
        <button class="btn btn-outline-secondary ts-btnFiltros" type="button"><i class="bi bi-funnel"></i></button>
      </div>

      <div class="col-4 col-lg-3 order-lg-2">
        <h2 class="ts-tituloPrincipal"><?php echo $contratoTipo['nomeDemanda'] ?></h2>
        <span>Filtro Aplicado</span>
      </div>

      <div class="col-6 col-lg-2 order-lg-3">
        <form class="text-end" action="" method="post">
          <div class="input-group">
            <select class="form-select ts-input" name="exportoptions" id="exportoptions">
              <option value="excel">Excel</option>
              <option value="pdf">PDF</option>
              <option value="csv">csv</option>
            </select>
            <button class="btn btn-warning" id="export" name="export" type="submit">Gerar</button>
          </div>
        </form>
      </div>

      <div class="col-12 col-lg-6 order-lg-4">
        <div class="input-group">
          <input type="text" class="form-control ts-input" id="buscaDemanda" placeholder="Buscar por id ou titulo">
          <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
          <button type="button" class="ms-4 btn btn-success ml-4" data-bs-toggle="modal" data-bs-target="#novoinserirDemandaModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
        </div>
      </div>

    </div>

    <!-- MENUFILTROS -->
    <div class="ts-menuFiltros mt-2 px-3">
      <label>Filtrar por:</label>

      <div class="ls-label col-sm-12"> <!-- ABERTO/FECHADO -->
        <form class="d-flex" action="" method="post">

          <select class="form-control" name="statusDemanda" id="FiltroStatusDemanda" onchange="mudarSelect(this.value)">
            <option value="<?php echo null ?>">
              <?php echo "Todos" ?>
            </option>
            <option <?php if ($statusDemanda == "1") {
                      echo "selected";
                    } ?> value="1">Aberto</option>
            <option <?php if ($statusDemanda == "2") {
                      echo "selected";
                    } ?> value="2">Execução</option>
            <option <?php if ($statusDemanda == "3") {
                      echo "selected";
                    } ?> value="3">Entregue</option>
            <option <?php if ($statusDemanda == "0") {
                      echo "selected";
                    } ?> value="0">Fechado</option>
          </select>

        </form>
      </div>

      <div class="col-sm text-end mt-2">
        <a onClick="limparTrade()" role=" button" class="btn btn-sm bg-info text-white">Limpar</a>
      </div>
    </div>

    <div class="table mt-2 ts-divTabela70 ts-tableFiltros text-center">
      <table class="table table-sm table-hover">
        <thead class="ts-headertabelafixo">
          <tr class="ts-headerTabelaLinhaCima">
            <th>Prioridade</th>
            <th>ID</th>
            <th>Cliente</th>
            <th>Solicitante</th>
            <th>Titulo</th>
            <th>Responsavel</th>
            <th>Abertura</th>
            <th>Status</th>
            <th>Ocorrência</th>
            <th>Data Entrega</th>
            <th>Posição</th>
            <th colspan="2"></th>
          </tr>
          <tr class="ts-headerTabelaLinhaBaixo">
            <th></th>
            <th></th>
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
                <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idSolicitante" id="FiltroSolicitante">
                  <option value="<?php echo null ?>">
                    <?php echo "Selecione" ?>
                  </option>
                  <?php
                  foreach ($usuarios as $usuariofiltro) {
                  ?>
                    <option <?php
                            if ($usuariofiltro['idUsuario'] == $idSolicitante) {
                              echo "selected";
                            }
                            ?> value="<?php echo $usuariofiltro['idUsuario'] ?>">
                      <?php echo $usuariofiltro['nomeUsuario'] ?>
                    </option>
                  <?php } ?>
                </select>
              </form>
            </th>
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
            <th></th>
            <th>
              <form action="" method="post">
                <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idTipoStatus" id="FiltroTipoStatus" autocomplete="off">
                  <option value="<?php echo null ?>">
                    <?php echo "Selecione" ?>
                  </option>
                  <?php foreach ($tiposstatus as $tipostatus) { ?>
                    <option <?php
                            if ($tipostatus['idTipoStatus'] == $idTipoStatus) {
                              echo "selected";
                            }
                            ?> value="<?php echo $tipostatus['idTipoStatus'] ?>">
                      <?php echo $tipostatus['nomeTipoStatus'] ?>
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
                  foreach ($tipoocorrencias as $tipoocorrencia) {
                  ?>
                    <option <?php
                            if ($tipoocorrencia['idTipoOcorrencia'] == $idTipoOcorrencia) {
                              echo "selected";
                            }
                            ?> value="<?php echo $tipoocorrencia['idTipoOcorrencia'] ?>">
                      <?php echo $tipoocorrencia['nomeTipoOcorrencia'] ?>
                    </option>
                  <?php } ?>
                </select>
              </form>
            </th>
            <th></th>
            <th>
              <form action="" method="post">
                <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="posicao" id="FiltroPosicao">
                  <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                  <option value="0">Atendente</option>
                  <option value="1">Cliente</option>
                </select>
              </form>
            </th>
            <th></th>
          </tr>
        </thead>

        <tbody id='dados' class="fonteCorpo">

        </tbody>
      </table>
    </div>

    <?php include_once 'modalDemanda_inserir.php' ?>



  </div><!--container-fluid-->

  <!-- LOCAL PARA COLOCAR OS JS -->

  <?php include_once ROOT . "/vendor/footer_js.php"; ?>
  <!-- script para menu de filtros -->
  <script src="<?php echo URLROOT ?>/sistema/js/filtroTabela.js"></script>
  <!-- QUILL editor -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <!-- Cards funcionado como botões -->
  <script src="../js/demanda_cards.js"></script>

  <script>
    var urlContratoTipo = '<?php echo $urlContratoTipo ?>';

    buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());

    function limparTrade() {
      buscar(null, null, null, null, null, null, null, null, function() {
        window.location.reload();
      });
    }

    function clickCard(statusDemanda) {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(),
        statusDemanda, $("#buscaDemanda").val(), $("#FiltroPosicao").val())
    }

    function buscar(idCliente, idSolicitante, idAtendente, idTipoStatus, idTipoOcorrencia, statusDemanda, buscaDemanda, posicao, callback) {
      //alert(posicao)
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '<?php echo URLROOT ?>/services/database/demanda.php?operacao=filtrar',
        beforeSend: function() {
          $("#dados").html("Carregando...");
        },
        data: {
          idCliente: idCliente,
          idSolicitante: idSolicitante,
          idAtendente: idAtendente,
          idTipoStatus: idTipoStatus,
          idTipoOcorrencia: idTipoOcorrencia,
          statusDemanda: statusDemanda,
          buscaDemanda: buscaDemanda,
          urlContratoTipo: urlContratoTipo,
          posicao: posicao
        },
        success: function(msg) {
          var json = JSON.parse(msg);
          var linha = "";
          for (var $i = 0; $i < json.length; $i++) {
            var object = json[$i];
            var dataAbertura = new Date(object.dataAbertura);
            var dataFormatada = dataAbertura.toLocaleDateString("pt-BR");

            if (object.dataFechamento == null) {
              var dataFechamentoFormatada = "<p>---</p>";
            } else {
              var dataFechamento = new Date(object.dataFechamento);
              dataFechamentoFormatada = dataFechamento.toLocaleDateString("pt-BR") + "<br> " + dataFechamento.toLocaleTimeString("pt-BR");
            }

            if (object.posicao == 0) {
              var posicao = "Atendente"
            }
            if (object.posicao == 1) {
              var posicao = "Cliente"
            }


            linha += "<tr>";  
            /* helio 09112023 - classe ts-click para quando clicar,
               data-idDemanda para guardar o id da demanda */
            linha += "<td class='ts-click' data-idDemanda='" + object.idDemanda + "'>" + object.prioridade + "</td>";
            linha += "<td class='ts-click' data-idDemanda='" + object.idDemanda + "'>" + object.idDemanda + "</td>";
            linha += "<td class='ts-click' data-idDemanda='" + object.idDemanda + "'>" + object.nomeCliente + "</td>";
            linha += "<td class='ts-click' data-idDemanda='" + object.idDemanda + "'>" + object.nomeSolicitante + "</td>";
            linha += "<td class='ts-click' data-idDemanda='" + object.idDemanda + "'>" + object.tituloDemanda + "</td>";
            linha += "<td class='ts-click' data-idDemanda='" + object.idDemanda + "'>" + object.nomeAtendente + "</td>";
            linha += "<td class='ts-click' data-idDemanda='" + object.idDemanda + "'>" + dataFormatada + "</td>";
            linha += "<td  data-idDemanda='" + object.idDemanda + "' class='" + object.idTipoStatus + "'>" + object.nomeTipoStatus + "</td>";
            linha += "<td class='ts-click' data-idDemanda='" + object.idDemanda + "'>" + object.nomeTipoOcorrencia + "</td>";
            linha += "<td class='ts-click' data-idDemanda='" + object.idDemanda + "'>" + dataFechamentoFormatada + "</td>";
            linha += "<td class='ts-click' data-idDemanda='" + object.idDemanda + "'>" + posicao + "</td>";

            linha += "<td>"; 
            linha += "<div class='btn-group dropstart'><button type='button' class='btn' data-toggle='tooltip' data-placement='left' title='Opções' data-bs-toggle='dropdown' " +
            " aria-expanded='false' style='box-shadow:none'><i class='bi bi-three-dots-vertical'></i></button><ul class='dropdown-menu'>"

            linha += "<li class='ms-1 me-1 mt-1'><a class='btn btn-warning btn-sm w-100 text-white text-start' href='visualizar.php?idDemanda=" + object.idDemanda + 
            "' role='button'><i class='bi bi-pencil-square'></i> Alterar</a></li>";

            linha += "</tr>";
            linha +="</ul></div>"
            linha += "</td>";
          }

          $("#dados").html(linha);

          if (typeof callback === 'function') {
            callback();
          }
        }
      });
    }

    /* helio 09112023 - ao clicar em ts-click, chama visualizar */
    $(document).on('click', '.ts-click', function() {
        window.location.href='visualizar.php?idDemanda=' + $(this).attr('data-idDemanda');
    });

   function trabrelinkx(parametros)
   {
       
   }


    $("#FiltroTipoStatus").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());
    });

    $("#FiltroClientes").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());
    });

    $("#FiltroSolicitante").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());
    });

    $("#FiltroOcorrencia").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());
    });

    $("#FiltroUsuario").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());
    });

    $("#FiltroStatusDemanda").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());
    });

    $("#buscar").click(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());
    });

    $("#FiltroPosicao").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());
    });

    document.addEventListener("keypress", function(e) {
      if (e.key === "Enter") {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());
      }
    });



    //Gabriel 22092023 id544 trocado setcookie por httpRequest enviado para gravar origem em session//ajax
    $(document).on('click', '#visualizarDemandaButton', function() {
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



    //**************exporta excel 
    function exportToExcel() {
      var idAtendenteValue = <?php echo $_SESSION['idCliente'] === NULL ? '$("#FiltroUsuario").val()' : 'null' ?>;
      var tamanhoValue = <?php echo $_SESSION['idCliente'] === NULL ? '$("#FiltroTamanho").val()' : 'null' ?>;
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '../database/demanda.php?operacao=filtrar',
        data: {
          idCliente: $("#FiltroClientes").val(),
          idSolicitante: $("#FiltroSolicitante").val(),
          idAtendente: idAtendenteValue,
          idTipoStatus: $("#FiltroTipoStatus").val(),
          idTipoOcorrencia: $("#FiltroOcorrencia").val(),
          statusDemanda: $("#FiltroStatusDemanda").val(),
          buscaDemanda: $("#buscaDemanda").val(),
          tamanho: tamanhoValue,
          urlContratoTipo: urlContratoTipo
        },
        success: function(json) {
          var excelContent =
            "<html xmlns:x='urn:schemas-microsoft-com:office:excel'>" +
            "<head>" +
            "<meta charset='UTF-8'>" +
            "</head>" +
            "<body>" +
            "<table>";

          excelContent += "<tr><th>Prioridade</th><th>ID</th><th>Cliente</th><th>Solicitante</th><th>Demanda</th><th>Responsavel</th><th>Abertura</th><th>Status</th><th>Ocorrencia</th><th>Tamanho</th></tr>";

          for (var i = 0; i < json.length; i++) {
            var object = json[i];
            excelContent += "<tr><td>" + object.prioridade + "</td>" +
              "<td>" + object.idDemanda + "</td>" +
              "<td>" + object.nomeCliente + "</td>" +
              "<td>" + object.nomeSolicitante + "</td>" +
              "<td>" + object.tituloDemanda + "</td>" +
              "<td>" + object.nomeAtendente + "</td>" +
              "<td>" + object.dataAbertura + "</td>" +
              "<td>" + object.nomeTipoStatus + "</td>" +
              "<td>" + object.nomeTipoOcorrencia + "</td>" +
              "<td>" + object.tamanho + "</td></tr>";
          }

          excelContent += "</table></body></html>";

          var excelBlob = new Blob([excelContent], {
            type: 'application/vnd.ms-excel'
          });
          var excelUrl = URL.createObjectURL(excelBlob);
          var link = document.createElement("a");
          link.setAttribute("href", excelUrl);
          link.setAttribute("download", "demandas.xls");
          document.body.appendChild(link);

          link.click();

          document.body.removeChild(link);
        },
        error: function(e) {
          alert('Erro: ' + JSON.stringify(e));
        }
      });
    }



    //**************exporta csv
    function exportToCSV() {
      var idAtendenteValue = <?php echo $_SESSION['idCliente'] === NULL ? '$("#FiltroUsuario").val()' : 'null' ?>;
      var tamanhoValue = <?php echo $_SESSION['idCliente'] === NULL ? '$("#FiltroTamanho").val()' : 'null' ?>;
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '../database/demanda.php?operacao=filtrar',
        data: {
          idCliente: $("#FiltroClientes").val(),
          idSolicitante: $("#FiltroSolicitante").val(),
          idAtendente: idAtendenteValue,
          idTipoStatus: $("#FiltroTipoStatus").val(),
          idTipoOcorrencia: $("#FiltroOcorrencia").val(),
          statusDemanda: $("#FiltroStatusDemanda").val(),
          buscaDemanda: $("#buscaDemanda").val(),
          tamanho: tamanhoValue,
          urlContratoTipo: urlContratoTipo
        },
        success: function(json) {
          var csvContent = "data:text/csv;charset=utf-8,\uFEFF";
          csvContent += "Prioridade,ID,Cliente,Solicitante,Demanda,Responsavel,Abertura,Status,Ocorrencia,Tamanho,Previsao\n";

          for (var i = 0; i < json.length; i++) {
            var object = json[i];
            csvContent += object.prioridade + "," +
              object.idDemanda + "," +
              object.nomeCliente + "," +
              object.nomeSolicitante + "," +
              object.tituloDemanda + "," +
              object.nomeAtendente + "," +
              object.dataAbertura + "," +
              object.nomeTipoStatus + "," +
              object.nomeTipoOcorrencia + "," +
              object.tamanho + "," +
              object.horasPrevisao + "\n";
          }

          var encodedUri = encodeURI(csvContent);
          var link = document.createElement("a");
          link.setAttribute("href", encodedUri);
          link.setAttribute("download", "demandas.csv");
          document.body.appendChild(link);

          link.click();

          document.body.removeChild(link);
        },
        error: function(e) {
          alert('Erro: ' + JSON.stringify(e));
        }
      });
    }

    //**************exporta PDF
    function exportToPDF() {
      var idAtendenteValue = <?php echo $_SESSION['idCliente'] === NULL ? '$("#FiltroUsuario").val()' : 'null' ?>;
      var tamanhoValue = <?php echo $_SESSION['idCliente'] === NULL ? '$("#FiltroTamanho").val()' : 'null' ?>;
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '../database/demanda.php?operacao=filtrar',
        data: {
          idCliente: $("#FiltroClientes").val(),
          idSolicitante: $("#FiltroSolicitante").val(),
          idAtendente: idAtendenteValue,
          idTipoStatus: $("#FiltroTipoStatus").val(),
          idTipoOcorrencia: $("#FiltroOcorrencia").val(),
          statusDemanda: $("#FiltroStatusDemanda").val(),
          buscaDemanda: $("#buscaDemanda").val(),
          tamanho: tamanhoValue,
          urlContratoTipo: urlContratoTipo
        },
        success: function(json) {
          var tableContent =
            "<table>" +
            "<tr><th>Prioridade</th><th>ID</th><th>Cliente</th><th>Solicitante</th><th>Demanda</th><th>Responsavel</th><th>Abertura</th><th>Status</th><th>Ocorrencia</th><th>Tamanho</th></tr>";

          for (var i = 0; i < json.length; i++) {
            var object = json[i];
            tableContent += "<tr><td>" + object.prioridade + "</td>" +
              "<td>" + object.idDemanda + "</td>" +
              "<td>" + object.nomeCliente + "</td>" +
              "<td>" + object.nomeSolicitante + "</td>" +
              "<td>" + object.tituloDemanda + "</td>" +
              "<td>" + object.nomeAtendente + "</td>" +
              "<td>" + object.dataAbertura + "</td>" +
              "<td>" + object.nomeTipoStatus + "</td>" +
              "<td>" + object.nomeTipoOcorrencia + "</td>" +
              "<td>" + object.tamanho + "</td></tr>";
          }

          tableContent += "</table>";

          var printWindow = window.open('', '', 'width=800,height=600');
          printWindow.document.open();
          printWindow.document.write('<html><head><title>Demandas</title></head><body>');
          printWindow.document.write(tableContent);
          printWindow.document.write('</body></html>');
          printWindow.document.close();

          printWindow.onload = function() {
            printWindow.print();
            printWindow.onafterprint = function() {
              printWindow.close();
            };
          };

          printWindow.onload();
        },
        error: function(e) {
          alert('Erro: ' + JSON.stringify(e));
        }
      });
    }





    $("#export").click(function() {
      var selectedOption = $("#exportoptions").val();
      if (selectedOption === "excel") {
        exportToExcel();
      } else if (selectedOption === "pdf") {
        exportToPDF();
      } else if (selectedOption === "csv") {
        exportToCSV();
      }
    });

    var demandaContrato = new Quill('.quill-demandainserir', {
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
          /*  [{
             'header': [1, 2, 3, 4, 5, 6, false]
           }], */
          ['link', 'image'],
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

    demandaContrato.on('text-change', function(delta, oldDelta, source) {
      $('#quill-demandainserir').val(demandaContrato.container.firstChild.innerHTML);
    });
  </script>

  <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>