<?php
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


include_once(__DIR__ . '/../head.php');
include_once(__DIR__ . '/../database/demanda.php');
//include_once '../database/demanda.php';
include_once(ROOT.'/sistema/database/clientes.php');
include_once(ROOT.'/sistema/database/usuario.php');
include_once(__DIR__ . '/../database/tipostatus.php');
include_once(__DIR__ . '/../database/tipoocorrencia.php');
//include_once '../database/tipostatus.php';
//include_once '../database/tipoocorrencia.php';



$clientes = buscaClientes();
$atendentes = buscaAtendente();
$usuarios = buscaUsuarios();
$tiposstatus = buscaTipoStatus();
$tipoocorrencias = buscaTipoOcorrencia();
$cards = buscaCardsDemanda();


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
  $tamanho = $filtroEntrada['tamanho'];
}

?>
<style>
  [class="<?php echo TIPOSTATUS_FILA ?>"] {
    margin-top: 5px;
    display: inline-block;
    background: #5271FE;
    color: #fff;
    width: 160px;
  }

  [class="<?php echo TIPOSTATUS_AGENDADO ?>"] {
    margin-top: 5px;
    display: inline-block;
    background: #FE5469;
    color: #fff;
    width: 160px;
  }

  [class="<?php echo TIPOSTATUS_REALIZADO ?>"] {
    display: inline-block;
    background: #C34A36;
    color: #fff;
    width: 160px;
  }

  [class="<?php echo TIPOSTATUS_FAZENDO ?>"] {
    margin-top: 5px;
    display: inline-block;
    background: #69419D;
    color: #fff;
    width: 160px;
  }

  [class="<?php echo TIPOSTATUS_RETORNO ?>"] {
    margin-top: 5px;
    display: inline-block;
    background: #FEA051;
    color: #fff;
    width: 160px;
  }

  [class="<?php echo TIPOSTATUS_VALIDADO ?>"] {
    margin-top: 5px;
    display: inline-block;
    background: #18B376;
    color: #fff;
    width: 160px;
  }

  [class="<?php echo TIPOSTATUS_AGUARDANDOSOLICITANTE ?>"] {
    margin-top: 5px;
    display: inline-block;
    background: #00C2A8;
    width: 160px;
    color: #fff;
  }

  [class="<?php echo TIPOSTATUS_RESPONDIDO ?>"] {
    margin-top: 5px;
    display: inline-block;
    background: blueviolet;
    color: #fff;
    width: 160px;
  }

  [class="<?php echo TIPOSTATUS_PAUSADO ?>"] {
    margin-top: 5px;
    display: inline-block;
    background: #FFC107;
    color: #fff;
    width: 160px;
  }
</style>

<body class="bg-transparent">
  <div class="container-fluid py-1">
    <div class="header-body">
      <div class="row row-cols-6">

        <div class="col my-2">
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-secondary text-uppercase text-success">Total de Chamado</div>
                <div class="h5 mb-0  text-gray-800 ml-1">
                  <?php echo $cards['totalDemandas'] ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col my-2">
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-secondary text-info text-uppercase ">Abertos</div>
                <div class="h5 mb-0  text-gray-800 ml-1">
                  <?php echo $cards['totalAbertos'] ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col my-2">
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-secondary text-warning text-uppercase ">Encerrados</div>
                <div class="h5 mb-0  text-gray-800 ml-1">
                  <?php echo $cards['totalFechados'] ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col my-2">
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-secondary text-danger text-uppercase ">Aguardando</div>
                <div class="h5 mb-0  text-gray-800 ml-1">
                  <?php echo $cards['totalAguardando'] ?>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>

  <nav id="menuFiltros" class="menuFiltros"> <!-- MENUFILTROS -->
    <div class="titulo"><span>Filtrar por:</span></div>
    <ul>

      <?php /*<li class="ls-label col-sm-12"> <!-- CLIENTE -->
<form class="d-flex" action="" method="post" style="text-align: right; margin-right:5px">

<?php if ($_SESSION['idCliente'] == null){ ?>
<select class="form-control fonteSelect" name="idCliente" id="FiltroClientes" style="font-size: 14px; width: 150px; height: 35px">
<option value="<?php echo null ?>"><?php echo " Cliente"  ?></option>
<?php
foreach ($clientes as $cliente) {
?>
<option <?php
if ($cliente['idCliente'] == $idCliente) {
echo "selected";
}
?> value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente']  ?></option>
<?php  } ?>
</select>
<?php  } else { ?>
<select class="form-control fonteSelect" name="idCliente" id="FiltroClientes" style="font-size: 14px; width: 150px; height: 35px" disabled>
<?php
foreach ($clientes as $cliente) {
?>
<option <?php
if ($cliente['idCliente'] == $idCliente) {
echo "selected";
}
?> value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente']  ?></option>
<?php  } ?>
</select>
<?php  } ?>


</form>
</li>

<li class="ls-label col-sm-12 mr-1"> <!-- RESPONSAVEL -->
<form class="d-flex" action="" method="post" style="text-align: right;">

<select class="form-control" name="idAtendente" id="FiltroUsuario" style="font-size: 14px; width: 150px; height: 35px">
<option value="<?php echo null ?>"><?php echo " Responsável"  ?></option>
<?php
foreach ($atendentes as $atendente) {
?>
<option <?php
if ($atendente['idUsuario'] == $idAtendente) {
echo "selected";
}
?> value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario']  ?></option>
<?php  } ?>
</select>

</form>
</li>

<li class="ls-label col-sm-12 mr-1"> <!-- SOLICITANTE -->
<form class="d-flex" action="" method="post" style="text-align: right;">

<select class="form-control" name="idSolicitante" id="FiltroSolicitante" style="font-size: 14px; width: 150px; height: 35px">
<option value="<?php echo null ?>"><?php echo " Solicitante"  ?></option>
<?php
foreach ($usuarios as $usuario) {
?>
<option <?php
if ($usuario['idUsuario'] == $idSolicitante) {
echo "selected";
}
?> value="<?php echo $usuario['idUsuario'] ?>"><?php echo $usuario['nomeUsuario']  ?></option>
<?php  } ?>
</select>

</form>
</li>

<li class="ls-label col-sm-12 mr-1"> <!-- STATUS -->
<form class="d-flex" action="" method="post" style="text-align: right; margin-right:5px">

<select class="form-control" name="idTipoStatus" id="FiltroTipoStatus" autocomplete="off" style="font-size: 14px; width: 150px; height: 35px">
<option value="<?php echo null ?>"><?php echo " Status"  ?></option>
<?php foreach ($tiposstatus as $tipostatus) { ?>
<option <?php
if ($tipostatus['idTipoStatus'] == $idTipoStatus) {
echo "selected";
}
?> value="<?php echo $tipostatus['idTipoStatus'] ?>"><?php echo $tipostatus['nomeTipoStatus'] ?></option>
<?php } ?>
</select>

</form>
</li>


<li class="ls-label col-sm-12 mr-1"> <!-- OCORRENCIA -->
<form class="d-flex" action="" method="post" style="text-align: right;">

<select class="form-control" name="idTipoOcorrencia" id="FiltroOcorrencia" style="font-size: 14px; width: 150px; height: 35px">
<option value="<?php echo null ?>"><?php echo "Ocorrência"  ?></option>
<?php
foreach ($tipoocorrencias as $tipoocorrencia) {
?>
<option <?php
if ($tipoocorrencia['idTipoOcorrencia'] == $idTipoOcorrencia) {
echo "selected";
}
?> value="<?php echo $tipoocorrencia['idTipoOcorrencia'] ?>"><?php echo $tipoocorrencia['nomeTipoOcorrencia']  ?></option>
<?php  } ?>
</select>

</form>
</li>

<li class="ls-label col-sm-12 mr-1"> <!-- TAMANHO -->
<form class="d-flex" action="" method="post" style="text-align: right;">

<select class="form-control" name="tamanho" id="FiltroTamanho" style="font-size: 14px; width: 150px; height: 35px">
<option value="<?php echo null ?>"><?php echo "Tamanho"  ?></option>
<option  value="P">P</option>
<option  value="M">M</option>
<option  value="G">G</option>
</select>

</form>
</li> */?>

      <li class="ls-label col-sm-12 mr-1"> <!-- ABERTO/FECHADO -->
        <form class="d-flex" action="" method="post" style="text-align: right;">

          <select class="form-control" name="statusDemanda" id="FiltroStatusDemanda"
            style="font-size: 14px; width: 150px; height: 35px">
            <option value="<?php echo null ?>"><?php echo "Todos" ?></option>
            <option <?php if ($statusDemanda == "1") {
              echo "selected";
            } ?> value="1">Aberto</option>
            <option <?php if ($statusDemanda == "0") {
              echo "selected";
            } ?> value="0">Fechado</option>
          </select>

        </form>
      </li>

    </ul>

    <div class="col-sm" style="text-align:right; color: #fff">
      <?php if ($_SESSION['idCliente'] == null) { ?>
        <a onClick="limparTrade()" role=" button" class="btn btn-sm" style="background-color:#84bfc3; ">Limpar</a>
      <?php } else { ?>
        <a onClick="limpar()" role=" button" class="btn btn-sm" style="background-color:#84bfc3; ">Limpar</a>
      <?php } ?>
    </div>
  </nav>


  <div class="container-fluid text-center mt-4">




    <div class="row">
      <div class=" btnAbre">
        <span style="font-size: 25px" class="material-symbols-outlined">
          filter_alt
        </span>

      </div>

      <div class="col-sm-3 ml-2">
        <p class="tituloTabela">Demandas</p>
      </div>

      <div class="col-sm-4" style="margin-top:-10px;">
        <div class="input-group">
          <input type="text" class="form-control" id="tituloDemanda" placeholder="Buscar por...">
          <span class="input-group-btn">
            <button class="btn btn-primary" id="buscar" type="button" style="margin-top:10px;">
              <span style="font-size: 20px" class="material-symbols-outlined">search</span>
            </button>
          </span>
        </div>
      </div>
      <div class="col-sm-1" style="margin-top:-10px;">
        <form class="d-flex" action="" method="post" style="text-align: right;">
          <select class="form-control" name="exportoptions" id="exportoptions">
            <option value="excel">Excel</option>
            <option value="pdf">PDF</option>
            <option value="csv">csv</option>
          </select>
        </form>
      </div>
      <div class="col-sm-1" style="margin-left:-30px;">
        <button class="btn btn-warning" id="export" name="export" type="submit">Gerar</button>
      </div>



      <div class="col-sm" style="text-align:right">
        <a href="demanda_inserir.php" role="button" class="btn btn-success">Adicionar Demanda</a>
      </div>
    </div>



    <div class="card mt-2">
      <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame">
        <table class="table">
          <thead class="thead-light">
            <?php if ($_SESSION['idCliente'] == NULL) { ?>
              <tr>
                <th class="text-center">Prioridade</th>
                <th class="text-center">ID</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Solicitante</th>
                <th class="text-center">Demanda</th>
                <th class="text-center">Responsavel</th>
                <th class="text-center">Abertura</th>
                <th class="text-center">Status</th>
                <th class="text-center">Ocorrência</th>
                <th class="text-center">Tamanho</th>
                <th class="text-center">Ação</th>
              </tr>
              <tr>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center" style="width: 10%;">
                  <form action="" method="post">
                    <select class="form-control text-center" name="idCliente" id="FiltroClientes"
                      style="font-size: 14px; font-weight: bold; margin-top:-10px; margin-bottom:-6px;">
                      <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                      <?php
                      foreach ($clientes as $cliente) {
                        ?>
                        <option <?php
                        if ($cliente['idCliente'] == $idCliente) {
                          echo "selected";
                        }
                        ?> value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                      <?php } ?>
                    </select>
                  </form>
                </th>
                <th class="text-center" style="width: 10%;">
                  <form action="" method="post">
                    <select class="form-control text-center" name="idSolicitante" id="FiltroSolicitante"
                      style="font-size: 14px; font-weight: bold; margin-top:-10px; margin-bottom:-6px;">
                      <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                      <?php
                      foreach ($usuarios as $usuario) {
                        ?>
                        <option <?php
                        if ($usuario['idUsuario'] == $idSolicitante) {
                          echo "selected";
                        }
                        ?>    value="<?php echo $usuario['idUsuario'] ?>"><?php echo $usuario['nomeUsuario'] ?></option>
                      <?php } ?>
                    </select>
                  </form>
                </th>
                <th class="text-center"></th>
                <th class="text-center">
                  <form action="" method="post">
                    <select class="form-control text-center" name="idAtendente" id="FiltroUsuario"
                      style="font-size: 14px; font-weight: bold; margin-top:-10px; margin-bottom:-6px;">
                      <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                      <?php
                      foreach ($atendentes as $atendente) {
                        ?>
                        <option <?php
                        if ($atendente['idUsuario'] == $idAtendente) {
                          echo "selected";
                        }
                        ?> value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
                      <?php } ?>
                    </select>
                  </form>
                </th>
                <th class="text-center"></th>
                <th class="text-center">
                  <form action="" method="post">
                    <select class="form-control text-center" name="idTipoStatus" id="FiltroTipoStatus" autocomplete="off"
                      style="font-size: 14px; font-weight: bold; margin-top:-10px; margin-bottom:-6px;">
                      <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                      <?php foreach ($tiposstatus as $tipostatus) { ?>
                        <option <?php
                        if ($tipostatus['idTipoStatus'] == $idTipoStatus) {
                          echo "selected";
                        }
                        ?> value="<?php echo $tipostatus['idTipoStatus'] ?>"><?php echo $tipostatus['nomeTipoStatus'] ?>
                        </option>
                      <?php } ?>
                    </select>
                  </form>
                </th>
                <th class="text-center" style="width: 10%;">
                  <form action="" method="post">
                    <select class="form-control text-center" name="idTipoOcorrencia" id="FiltroOcorrencia"
                      style="font-size: 14px; font-weight: bold; margin-top:-10px; margin-bottom:-6px;">
                      <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                      <?php
                      foreach ($tipoocorrencias as $tipoocorrencia) {
                        ?>
                        <option <?php
                        if ($tipoocorrencia['idTipoOcorrencia'] == $idTipoOcorrencia) {
                          echo "selected";
                        }
                        ?> value="<?php echo $tipoocorrencia['idTipoOcorrencia'] ?>"><?php echo $tipoocorrencia['nomeTipoOcorrencia'] ?></option>
                      <?php } ?>
                    </select>
                  </form>
                </th>
                <th class="text-center" style="width: 10%;">
                  <form action="" method="post">
                    <select class="form-control text-center" name="tamanho" id="FiltroTamanho"
                      style="font-size: 14px; font-weight: bold; margin-top:-10px; margin-bottom:-6px;">
                      <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                      <option value="P">P</option>
                      <option value="M">M</option>
                      <option value="G">G</option>
                    </select>
                  </form>
                </th>
                <th class="text-center"></th>
                <th class="text-center"></th>
              </tr>

            <?php } //******************visão do Cliente 
            else { ?>
              <tr>
                <th class="text-center">Prioridade</th>
                <th class="text-center">ID</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Solicitante</th>
                <th class="text-center">Demanda</th>
                <th class="text-center">Status</th>
                <th class="text-center">Ocorrência</th>
                <th class="text-center">Ação</th>
              </tr>
              <tr>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center" style="width: 10%;">
                  <form action="" method="post">
                    <select class="form-control text-center" name="idCliente" id="FiltroClientes"
                      style="font-size: 14px; font-weight: bold; margin-top:-10px; margin-bottom:-6px;" disabled>
                      <?php
                      foreach ($clientes as $cliente) {
                        ?>
                        <option <?php
                        if ($cliente['idCliente'] == $idCliente) {
                          echo "selected";
                        }
                        ?> value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                      <?php } ?>
                    </select>
                  </form>
                </th>
                <th class="text-center" style="width: 10%;">
                  <form action="" method="post">
                    <select class="form-control text-center" name="idSolicitante" id="FiltroSolicitante"
                      style="font-size: 14px; font-weight: bold; margin-top:-10px; margin-bottom:-6px;">
                      <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                      <?php
                      foreach ($usuarios as $usuario) {
                        ?>
                        <option <?php
                        if ($usuario['idUsuario'] == $idSolicitante) {
                          echo "selected";
                        }
                        ?>              value="<?php echo $usuario['idUsuario'] ?>"><?php echo $usuario['nomeUsuario'] ?></option>
                      <?php } ?>
                    </select>
                  </form>
                </th>
                <th class="text-center"></th>
                <th class="text-center">
                  <form action="" method="post">
                    <select class="form-control text-center" name="idTipoStatus" id="FiltroTipoStatus" autocomplete="off"
                      style="font-size: 14px; font-weight: bold; margin-top:-10px; margin-bottom:-6px;">
                      <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                      <?php foreach ($tiposstatus as $tipostatus) { ?>
                        <option <?php
                        if ($tipostatus['idTipoStatus'] == $idTipoStatus) {
                          echo "selected";
                        }
                        ?> value="<?php echo $tipostatus['idTipoStatus'] ?>"><?php echo $tipostatus['nomeTipoStatus'] ?>
                        </option>
                      <?php } ?>
                    </select>
                  </form>
                </th>
                <th class="text-center" style="width: 10%;">
                  <form action="" method="post">
                    <select class="form-control text-center" name="idTipoOcorrencia" id="FiltroOcorrencia"
                      style="font-size: 14px; font-weight: bold; margin-top:-10px; margin-bottom:-6px;">
                      <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                      <?php
                      foreach ($tipoocorrencias as $tipoocorrencia) {
                        ?>
                        <option <?php
                        if ($tipoocorrencia['idTipoOcorrencia'] == $idTipoOcorrencia) {
                          echo "selected";
                        }
                        ?> value="<?php echo $tipoocorrencia['idTipoOcorrencia'] ?>"><?php echo $tipoocorrencia['nomeTipoOcorrencia'] ?></option>
                      <?php } ?>
                    </select>
                  </form>
                </th>
                <th class="text-center"></th>
              </tr>
            <?php } ?>
          </thead>

          <tbody id='dados' class="fonteCorpo">

          </tbody>
        </table>
      </div>
    </div>
  </div>



  <script>
    <?php if ($_SESSION['idCliente'] === NULL): ?>
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), $("#FiltroTamanho").val());

      function limparTrade() {
        buscar(null, null, null, null, null, null, null, null);
        window.location.reload();
      }


      function buscar(idCliente, idSolicitante, idAtendente, idTipoStatus, idTipoOcorrencia, statusDemanda, tituloDemanda, tamanho) {
        
        $.ajax({
          type: 'POST',
          dataType: 'html',
          url: '<?php echo URLROOT ?>/services/database/demanda.php?operacao=filtrar',
          beforeSend: function () {
            $("#dados").html("Carregando...");
          },
          data: {
            idCliente: idCliente,
            idSolicitante: idSolicitante,
            idAtendente: idAtendente,
            idTipoStatus: idTipoStatus,
            idTipoOcorrencia: idTipoOcorrencia,
            statusDemanda: statusDemanda,
            tituloDemanda: tituloDemanda,
            tamanho: tamanho
          },
          success: function (msg) {
            
            var json = JSON.parse(msg);
            var linha = "";
            for (var $i = 0; $i < json.length; $i++) {
              var object = json[$i];
              var dataAbertura = new Date(object.dataAbertura);
              var dataFormatada = dataAbertura.toLocaleDateString("pt-BR");

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
              linha += "<td>" + object.tamanho + " - " + object.horasPrevisao + "</td>";
              linha += "<td><a class='btn btn-primary btn-sm' href='visualizar.php?idDemanda=" + object.idDemanda + "' role='button'><i class='bi bi-eye-fill'></i></a></td>";
              linha += "</tr>";
            }

            $("#dados").html(linha);
          }
        });
      }

      $("#FiltroTipoStatus").change(function () {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), $("#FiltroTamanho").val());
      });

      $("#FiltroClientes").change(function () {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), $("#FiltroTamanho").val());
      });

      $("#FiltroSolicitante").change(function () {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), $("#FiltroTamanho").val());
      });

      $("#FiltroOcorrencia").change(function () {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), $("#FiltroTamanho").val());
      });

      $("#FiltroUsuario").change(function () {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), $("#FiltroTamanho").val());
      });

      $("#FiltroStatusDemanda").change(function () {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), $("#FiltroTamanho").val());
      });

      $("#buscar").click(function () {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), $("#FiltroTamanho").val());
      });

      $("#FiltroTamanho").click(function () {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), $("#FiltroTamanho").val());
      });

      document.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
          buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), $("#FiltroTamanho").val());
        }
      });
  <?php else: ?>
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), null);


    function limpar() {
      var idClienteOriginal = $("#FiltroClientes").val();
      buscar(idClienteOriginal, null, null, null, null, null, null, null);
      window.location.reload();
    }

    function buscar(idCliente, idSolicitante, idAtendente, idTipoStatus, idTipoOcorrencia, statusDemanda, tituloDemanda, tamanho) {
        
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '<?php echo URLROOT ?>/services/database/demanda.php?operacao=filtrar',
        beforeSend: function () {
          $("#dados").html("Carregando...");
        },
        data: {
          idCliente: idCliente,
          idSolicitante: idSolicitante,
          idAtendente: idAtendente,
          idTipoStatus: idTipoStatus,
          idTipoOcorrencia: idTipoOcorrencia,
          statusDemanda: statusDemanda,
          tituloDemanda: tituloDemanda,
          tamanho: tamanho
        },
        success: function (msg) {
         
          var json = JSON.parse(msg);
          var linha = "";
          for (var $i = 0; $i < json.length; $i++) {
            var object = json[$i];

            linha += "<tr>";
            linha += "<td>" + object.prioridade + "</td>";
            linha += "<td>" + object.idDemanda + "</td>";
            linha += "<td>" + object.nomeCliente + "</td>";
            linha += "<td>" + object.nomeSolicitante + "</td>";
            linha += "<td>" + object.tituloDemanda + "</td>";
            linha += "<td class='" + object.idTipoStatus + "'>" + object.nomeTipoStatus + "</td>";
            linha += "<td>" + object.nomeTipoOcorrencia + "</td>";
            linha += "<td><a class='btn btn-primary btn-sm' href='visualizar.php?idDemanda=" + object.idDemanda + "' role='button'><i class='bi bi-eye-fill'></i></a></td>";
            linha += "</tr>";
          }

          $("#dados").html(linha);
        }
      });
    }

    $("#FiltroTipoStatus").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), null);
    });

    $("#FiltroClientes").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), null);
    });

    $("#FiltroSolicitante").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), null);
    });

    $("#FiltroOcorrencia").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), null);
    });

    $("#FiltroUsuario").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), null);
    });

    $("#FiltroStatusDemanda").change(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), null);
    });

    $("#buscar").click(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), null);
    });

    $("#FiltroTamanho").click(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), null);
    });

    document.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), null, $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val(), null);
      }
    });
  <?php endif; ?>

      $('.btnAbre').click(function () {
        $('.menuFiltros').toggleClass('mostra');
        $('.diviFrame').toggleClass('mostra');
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
          tituloDemanda: $("#tituloDemanda").val(),
          tamanho: tamanhoValue
        },
        success: function (json) {
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

          var excelBlob = new Blob([excelContent], { type: 'application/vnd.ms-excel' });
          var excelUrl = URL.createObjectURL(excelBlob);
          var link = document.createElement("a");
          link.setAttribute("href", excelUrl);
          link.setAttribute("download", "demandas.xls");
          document.body.appendChild(link);

          link.click();

          document.body.removeChild(link);
        },
        error: function (e) {
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
          tituloDemanda: $("#tituloDemanda").val(),
          tamanho: tamanhoValue
        },
        success: function (json) {
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
        error: function (e) {
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
          tituloDemanda: $("#tituloDemanda").val(),
          tamanho: tamanhoValue
        },
        success: function (json) {
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

          printWindow.onload = function () {
            printWindow.print();
            printWindow.onafterprint = function () {
              printWindow.close();
            };
          };

          printWindow.onload();
        },
        error: function (e) {
          alert('Erro: ' + JSON.stringify(e));
        }
      });
    }





    $("#export").click(function () {
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
</body>

</html>