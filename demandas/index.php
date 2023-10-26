<?php
// Lucas 25102023 id643 revisao geral
// Lucas 16102023 novo padrao
//Gabriel 13102023 fix modal nova demanda 
//lucas 26092023 ID 576 Demanda/BOTÕES de SITUACOES 
// Gabriel 22092023 id 544 Demandas - Botão Voltar
//lucas 22092023 ID 358 Demandas/Comentarios 
// Lucas 22032023 ajustado função do botão de limpar
// Lucas 22032023 adicionado busca por barra de pesquisa, funcionado com pressionamento do Enter
// Lucas 21032023 adicionado forms para filtro de cliente, responsavel, usuario e ocorrencia, fazendo a requisição via ajax.
// Lucas 20032023 alterado select de idTipoStatus para acionar uma função js, botão "buscar" foi removido, 
//  alterado botão de limpar para usar função onclick="buscar(null)"
// Lucas 20032023 Modificada a tabela ser construida via Javascript
// Lucas 13032023 - adicionado novo modelo para os cards
// helio 20022023 - Incluido class="table" no HTML <table>
// Helio 20022023 - integrado modificações para receber idTipoStatus no $_POST
// gabriel 06022023 ajuste na tabela
// helio 01022023 alterado para include_once
// helio 26012023 16:16

include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/demanda.php');
include_once(ROOT . '/cadastros/database/clientes.php');
include_once(ROOT . '/cadastros/database/usuario.php');
include_once(__DIR__ . '/../database/tipostatus.php');
include_once(__DIR__ . '/../database/tipoocorrencia.php');
include '../database/contratotipos.php';
include_once '../database/contratos.php';

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
  //lucas 26092023 ID 576 Adicionado posicao no filtro_demanda
  $posicao = $filtroEntrada['posicao'];
}


?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

  <!-- Gabriel 13102023 fix modal nova demanda, removido styles de modal --> 


<body>
  <div class="container-fluid">
    <div class="header-body">
      <div class="row row-cols-6">
        <!-- lucas 26092023 ID 576 Modificado estrutura dos cards -->
        <div class="col-12 col-md my-2">
          <div class="ts-cardColor card border-left-success ts-shadowOff py-0 ts-cardsTotais">
            <div class="row no-gutters align-items-center">
              <div class="col-12 col-md mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-secondary text-success text-uppercase ">Todos</div>
                <div class="h5 mb-0  text-gray-800 ml-1">
                  <?php echo $cards['totalDemandas'] ?>
                </div>
              </div>
            </div>
            <button class="ts-cardLink" onClick="clickCard(this.value)" value="" id=""></button>
          </div>
        </div>

        <div class="col-12 col-md my-2">
          <div class="ts-cardColor1 ts-cardColor-active card border-left-success  py-0 ts-cardsTotais">
            <div class="row no-gutters align-items-center">
              <div class="col-12 col-md mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-primary text-uppercase ">Aberto</div>
                <div class="h5 mb-0  text-gray-800 ml-1">
                  <?php echo $cards['totalAbertas'] ?>
                </div>
              </div>
            </div>
            <button class="ts-cardLink" onClick="clickCard(this.value)" value="1" id="1"></button>
          </div>
        </div>

        <div class="col-12 col-md my-2">
          <div class="ts-cardColor2 card border-left-success ts-shadowOff py-0 ts-cardsTotais">
            <div class="row no-gutters align-items-center">
              <div class="col-12 col-md mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-secondary text-info text-uppercase ">Execução</div>

                <div class="h5 mb-0  text-gray-800 ml-1">
                  <?php echo $cards['totalExecucao'] ?>
                </div>
              </div>
            </div>
            <button class="ts-cardLink" onClick="clickCard(this.value)" value="2" id="2"></button>
          </div>
        </div>

        <div class="col-12 col-md my-2">
          <div class="ts-cardColor3 card border-left-success ts-shadowOff py-0 ts-cardsTotais">
            <div class="row no-gutters align-items-center">
              <div class="col-12 col-md mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-secondary text-warning text-uppercase ">Entregue</div>

                <div class="h5 mb-0  text-gray-800 ml-1">
                  <?php echo $cards['totalEntregue'] ?>
                </div>
              </div>
            </div>
            <button class="ts-cardLink" onClick="clickCard(this.value)" value="3" id="3"></button>
          </div>
        </div>

        <div class="col-12 col-md my-2">
          <div class="ts-cardColor0 card border-left-success ts-shadowOff py-0 ts-cardsTotais">
            <div class="row no-gutters align-items-center">
              <div class="col-12 col-md mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-secondary text-danger text-uppercase ">Fechado</div>

                <div class="h5 mb-0  text-gray-800 ml-1">
                  <?php echo $cards['totalFechado'] ?>
                </div>
              </div>
            </div>
            <button class="ts-cardLink" onClick="clickCard(this.value)" value="0" id="0"></button>
          </div>
        </div>

        <!--  -->
      </div>
    </div>
  </div>

<!-- MENUFILTROS -->
  <nav class="ts-menuFiltros" style="margin-top: 20px;"> 
  <label class="pl-2" for="">Filtrar por:</label>
    
      <div class="ls-label col-sm-12 mr-1"> <!-- ABERTO/FECHADO -->
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
      <?php if ($ClienteSession == null) { ?>
        <a onClick="limparTrade()" role=" button" class="btn btn-sm bg-info text-white">Limpar</a>
      <?php } else { ?>
        <a onClick="limpar()" role=" button" class="btn btn-sm bg-info text-white">Limpar</a>
      <?php } ?>
    </div>
  </nav>

  <!-- Lucas 25102023 id643 include de modalDemanda_inserir -->
  <!--------- MODAL DEMANDA INSERIR --------->
  <?php include_once 'modalDemanda_inserir.php' ?>


  <div class="container-fluid text-center ">

    <div class="row align-items-center">
      <div class="col-4 order-1 col-sm-4  col-md-4 order-md-1 col-lg-1 order-lg-1 mt-3">
        <button type="button" class="ts-btnFiltros btn btn-sm"><span class="material-symbols-outlined">
            filter_alt
          </span></button>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-2 order-lg-2 mt-4">
        <h2 class="ts-tituloPrincipal">
          <?php echo $contratoTipo['nomeDemanda'] ?>
        </h2>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-5 order-lg-3">
        <div class="input-group">
          <input type="text" class="form-control ts-input" id="buscaDemanda" placeholder="Buscar por id ou titulo">
          <span class="input-group-btn">
            <button class="btn btn-primary" id="buscar" type="button" style="margin-top:10px;">
              <span style="font-size: 20px;font-family: 'Material Symbols Outlined'!important;" class="material-symbols-outlined">search</span>
            </button>
          </span>
        </div>
      </div>

      <div class="col-4 order-2 col-sm-4 col-md-4 order-md-2 d-flex col-lg-2 order-lg-4">
        <div class="col-8 mb-1">
          <form class="d-flex text-end" action="" method="post">
            <select class="form-select ts-input mt-3" name="exportoptions" id="exportoptions">
              <option value="excel">Excel</option>
              <option value="pdf">PDF</option>
              <option value="csv">csv</option>
            </select>
          </form>
        </div>
        <div class="col-4 mt-2">
          <button class="btn btn-warning" id="export" name="export" type="submit">Gerar</button>
        </div>

      </div>

      <div class="col-4 order-3 col-sm-4 col-md-4 order-md-3 col-lg-2 order-lg-5 mt-1 text-end">
        <button type="button" class="btn btn-success mr-4" data-bs-toggle="modal" data-bs-target="#inserirDemandaModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
      </div>
    </div>

      <div class="table ts-divTabela ts-tableFiltros table-striped table-hover">
        <table class="table table-sm">
          <thead class="ts-headertabelafixo">
            <?php if ($ClienteSession == NULL) { ?>
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
                <th>Fechamento</th>
                <!-- lucas 22092023 ID 358 Adicionado campo posição na tabela-->
                <th>Posição</th>
                <th colspan="2">Ação</th>
              </tr>
              <tr class="ts-headerTabelaLinhaBaixo">
                <th></th>
                <th></th>
                <th>
                  <form action="" method="post">
                    <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idCliente" id="FiltroClientes" >
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
                    <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idSolicitante" id="FiltroSolicitante" >
                      <option value="<?php echo null ?>">
                        <?php echo "Selecione" ?>
                      </option>
                      <?php
                      foreach ($usuarios as $usuario) {
                      ?>
                        <option <?php
                                if ($usuario['idUsuario'] == $idSolicitante) {
                                  echo "selected";
                                }
                                ?> value="<?php echo $usuario['idUsuario'] ?>">
                          <?php echo $usuario['nomeUsuario'] ?>
                        </option>
                      <?php } ?>
                    </select>
                  </form>
                </th>
                <th></th>
                <th>
                  <form action="" method="post">
                    <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idAtendente" id="FiltroUsuario" >
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
                    <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idTipoStatus" id="FiltroTipoStatus" autocomplete="off" >
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
                    <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idTipoOcorrencia" id="FiltroOcorrencia" >
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
                <!-- lucas 26092023 ID 576 Adicionado filtro posicao -->
                <th>
                  <form action="" method="post">
                    <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="posicao" id="FiltroPosicao" >
                      <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                      <option value="0">Atendente</option>
                      <option value="1">Cliente</option>
                    </select>
                  </form>
                </th>
                <th></th>
              </tr>
            <?php } //******************visão do Cliente 
            else { ?>
              <tr class="ts-headerTabelaLinhaCima">
                <th>Prioridade</th>
                <th>ID</th>
                <th>Cliente</th>
                <th>Solicitante</th>
                <th>Titulo</th>
                <th>Status</th>
                <th>Ocorrência</th>
                <th>Fechamento</th>
                <!-- lucas 22092023 ID 358 Adicionado campo posição na tabela-->
                <th>Posição</th>
                <th>Ação</th>
              </tr>
              <tr class="ts-headerTabelaLinhaBaixo">
                <th></th>
                <th></th>
                <th>
                  <form action="" method="post">
                    <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idCliente" id="FiltroClientes" disabled>
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
                      foreach ($usuarios as $usuario) {
                      ?>
                        <option <?php
                                if ($usuario['idUsuario'] == $idSolicitante) {
                                  echo "selected";
                                }
                                ?> value="<?php echo $usuario['idUsuario'] ?>">
                          <?php echo $usuario['nomeUsuario'] ?>
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
                <!-- lucas 26092023 ID 576 Adicionado filtro posicao -->
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
            <?php } ?>
          </thead>

          <tbody id='dados' class="fonteCorpo">

          </tbody>
        </table>
      
    </div>
  </div>

  <!-- LOCAL PARA COLOCAR OS JS -->
  
  <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- script para menu de filtros -->
    <script src= "<?php echo URLROOT ?>/sistema/js/filtroTabela.js"></script>
    <script src="../js/demanda_cards.js"></script>

  <script>
    <?php if ($ClienteSession === NULL) : ?>
      var urlContratoTipo = '<?php echo $urlContratoTipo ?>';
      //lucas 26092023 ID 576 Adicionado posicao no buscar
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val());

      function limparTrade() {
        buscar(null, null, null, null, null, null, null, null, function() {
          window.location.reload();
        });
      }

      //lucas 26092023 ID 576 Modificado função clickCard, passando os valores dos outros filtros
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
            /* lucas 26092023 ID 576 Adicionado posicao */
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
              /* lucas 22092023 ID 358 logica para mostar o nome em vez do numero */
              if (object.posicao == 0) {
                var posicao = "Atendente"
              }
              if (object.posicao == 1) {
                var posicao = "Cliente"
              }
              /*  */
              linha += "<tr>";
              linha += "<td>" + object.prioridade + "</td>";
              linha += "<td>" + object.idDemanda + "</td>";
              linha += "<td>" + object.nomeCliente + "</td>";
              linha += "<td>" + object.nomeSolicitante + "</td>";
              linha += "<td>" + object.tituloDemanda + "</td>";
              linha += "<td>" + object.nomeAtendente + "</td>";
              linha += "<td>" + dataFormatada + "</td>";
              linha += "<td class='" + object.idTipoStatus + "'>" + object.nomeTipoStatus + "</td>";
              linha += "<td>" + object.nomeTipoOcorrencia + "</td>";
              /* lucas 22092023 ID 358 Removido comentario */
              linha += "<td>" + dataFechamentoFormatada + "</td>";
              /* lucas 22092023 ID 358 Adicionado campo na tabela */
              linha += "<td>" + posicao + "</td>";
              linha += "<td><a class='btn btn-warning btn-sm' href='visualizar.php?idDemanda=" + object.idDemanda + "' role='button'><i class='bi bi-pencil-square'></i></a></td>";

              linha += "</tr>";
            }

            $("#dados").html(linha);

            if (typeof callback === 'function') {
              callback();
            }
          }
        });
      }

      /* lucas 26092023 ID 576 Adicionado filtro posicao */
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
      /*  */
    <?php else : ?>
      var urlContratoTipo = '<?php echo $urlContratoTipo ?>';
      /* lucas 26092023 ID 576 Adicionado filtro posicao */
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val(), null);


      function limpar() {
        var idClienteOriginal = $("#FiltroClientes").val();
        buscar(idClienteOriginal, null, null, null, null, null, null, null, function() {
          window.location.reload();
        });
      }

      //lucas 26092023 ID 576 Modificado função clickCard, passando os valores dos outros filtros
      function clickCard(statusDemanda) {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(),
          statusDemanda, $("#buscaDemanda").val(), $("#FiltroPosicao").val())
      }

      /* lucas 26092023 ID 576 Adicionado posicao no buscar */
      function buscar(idCliente, idSolicitante, idAtendente, idTipoStatus, idTipoOcorrencia, statusDemanda, buscaDemanda, posicao, callback) {

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
            /* lucas 26092023 ID 576 Adicionado posicao */
            posicao: posicao
          },
          success: function(msg) {

            var json = JSON.parse(msg);
            var linha = "";
            for (var $i = 0; $i < json.length; $i++) {
              var object = json[$i];

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
              linha += "<td>" + object.prioridade + "</td>";
              linha += "<td>" + object.idDemanda + "</td>";
              linha += "<td>" + object.nomeCliente + "</td>";
              linha += "<td>" + object.nomeSolicitante + "</td>";
              linha += "<td>" + object.tituloDemanda + "</td>";
              linha += "<td class='" + object.idTipoStatus + "'>" + object.nomeTipoStatus + "</td>";
              linha += "<td>" + object.nomeTipoOcorrencia + "</td>";
              linha += "<td>" + dataFechamentoFormatada + "</td>";
              /* lucas 22092023 ID 358 Adicionado campo na tabela */
              linha += "<td>" + posicao + "</td>";
              linha += "<td><a class='btn btn-warning btn-sm' href='visualizar.php?idDemanda=" + object.idDemanda + "' role='button'><i class='bi bi-pencil-square'></i></a></td>";

              linha += "</tr>";
            }

            $("#dados").html(linha);

            if (typeof callback === 'function') {
              callback();
            }
          }
        });
      }
      /* lucas 26092023 ID 576 Adicionado filtro posicao */
      $("#FiltroTipoStatus").change(function() {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val(), null);
      });

      $("#FiltroClientes").change(function() {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val(), null);
      });

      $("#FiltroSolicitante").change(function() {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val(), null);
      });

      $("#FiltroOcorrencia").change(function() {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val(), null);
      });

      $("#FiltroUsuario").change(function() {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val(), null);
      });

      $("#FiltroStatusDemanda").change(function() {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val(), null);
      });

      $("#buscar").click(function() {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val(), null);
      });

      $("#FiltroPosicao").change(function() {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val(), null);
      });

      document.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
          buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#buscaDemanda").val(), $("#FiltroPosicao").val(), null);
        }
      });
      /*  */
    <?php endif; ?>


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
  </script>

  <script>
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