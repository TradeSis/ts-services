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
// gabriel 01022023 15:07 - order by alterado, visual da tabela linha 119
// helio 26012023 16:16


include_once '../head.php';
include_once '../database/demanda.php';
include_once '../database/clientes.php';
include_once '../database/usuario.php';
include_once '../database/tipostatus.php';
include_once '../database/tipoocorrencia.php';



$clientes = buscaClientes();
$atendentes = buscaAtendente();
$usuarios = buscaUsuarios();
$tiposstatus = buscaTipoStatus();
$tipoocorrencias = buscaTipoOcorrencia();


if ($_SESSION['idCliente'] == null){
  $idCliente = null;
} else {
  $idCliente = $_SESSION['idCliente'];
}

if ($_SESSION['idCliente'] == null){
  $idAtendente = $_SESSION['idUsuario'];
} else {
  $idAtendente = null;
}
$statusDemanda = "1";  //ABERTO

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
  }
?>
<style>
[class="fila"] { 
  margin-top: 5px;
  display: inline-block;
  background: #5271FE;
  color: #fff;
  width: 160px;
}

[class="priorização"] {
  margin-top: 5px;
  display: inline-block;
  background: #FE5469;
  color: #fff;
  width: 160px;
}

[class="feito"] {
  display: inline-block;
  background: #C34A36;
  color: #fff;
  width: 160px;
}

[class="fazendo"] { 
  margin-top: 5px;
  display: inline-block;
  background: #69419D;
  color: #fff;
  width: 160px;
}

[class="retorno"] {
  margin-top: 5px;
  display: inline-block; 
  background: #FEA051;
  color: #fff;
  width: 160px;
}

[class="validado"] {
  margin-top: 5px;
  display: inline-block;
  background: #18B376;
  color: #fff;
  width: 160px;
}

[class="aguardando informação"] {
  margin-top: 5px;
  display: inline-block;
  background: #00C2A8;
  width: 160px;
  color: #fff;
}

[class="fila desenv"] {
  margin-top: 5px;
  display: inline-block;
  background: blueviolet;
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
                <div class="h5 mb-0  text-gray-800"><?php
                                                    /*foreach ($cards1 as $card1)
                    echo $card1['total'];*/
                                                    ?>
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
                <div class="h5 mb-0  text-gray-800"><?php
                                                    /*foreach ($cards2 as $card2)
                    echo $card1['total'];*/
                                                    ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col my-2">
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-secondary text-warning text-uppercase ">Fechados</div>
                <div class="h5 mb-0  text-gray-800"><?php
                                                    /*foreach ($cards2 as $card2)
                    echo $card2['total'];*/
                                                    ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col my-2">
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 mb-2 p-1">
                <div class="text-xs font-weight-bold text-secondary text-danger text-uppercase ">Desenvolvimento</div>
                <div class="h5 mb-0  text-gray-800"><?php
                                                    /*foreach ($cards2 as $card2)
                    echo $card2['total'];*/
                                                    ?>
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

      <li class="ls-label col-sm-12"> <!-- CLIENTE -->
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

      <li class="ls-label col-sm-12 mt-2 mr-1"> <!-- RESPONSAVEL -->
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

      <li class="ls-label col-sm-12 mt-2 mr-1"> <!-- RESPONSAVEL -->
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

      <li class="ls-label col-sm-12 mt-2 mr-1"> <!-- ABERTO/FECHADO -->
        <form class="d-flex" action="" method="post" style="text-align: right;">

          <select class="form-control" name="statusDemanda" id="FiltroStatusDemanda" style="font-size: 14px; width: 150px; height: 35px">
            <option value="<?php echo null ?>"><?php echo "Todos"  ?></option>
            <option <?php if ($statusDemanda == "1") { echo "selected"; } ?> value="1">Aberto</option>
            <option <?php if ($statusDemanda == "0") { echo "selected"; } ?> value="0">Fechado</option>
          </select>

        </form>
      </li>

      <li class="ls-label col-sm-12 mt-2 mr-1"> <!-- STATUS -->
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

      <li class="ls-label col-sm-12 mt-2 mr-1"> <!-- OCORRENCIA -->
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


    </ul>

    <div class="col-sm" style="text-align:right; color: #fff">
                <?php if ($_SESSION['idCliente'] == null){ ?>
                  <a onClick="limparTrade()" role=" button" class="btn btn-sm" style="background-color:#84bfc3; ">Limpar</a>
                <?php  } else { ?>
                  <a onClick="limpar()" role=" button" class="btn btn-sm" style="background-color:#84bfc3; ">Limpar</a>
                <?php  } ?>
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

          <div class="col-sm-4">
            <div class="input-group">
              <input type="text" class="form-control" id="tituloDemanda" placeholder="Buscar por...">
              <span class="input-group-btn">
                <button class="btn btn-primary" id="buscar" type="button">
                  <span style="font-size: 20px" class="material-symbols-outlined">search</span>
                </button>
              </span>
            </div>
          </div>



          <div class="col-sm" style="text-align:right">
            <a href="demanda_inserir.php" role="button" class="btn btn-success">Adicionar Demanda</a>
          </div>
        </div>

      

    <div class="card mt-2"> 
      <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame">
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th>Prioridade</th>
              <th>ID</th>
              <th>Cliente</th>
              <th>Solicitante</th>
              <th>Demanda</th>
              <th>Responsável</th>
              <th>Abertura</th>
              <th>Status</th>
              <th>Ocorrência</th>
              <th>Tamanho</th>
              <th>Ação</th>
            </tr>
          </thead>

          <tbody id='dados' class="fonteCorpo">

          </tbody>
        </table>
      </div>
    </div>
  </div>



  <script>
    buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val());

    function limparTrade() {
      buscar(null, null, null, null, null, null, null);
      window.location.reload();
    }
    function limpar() {
      var idClienteOriginal = $("#FiltroClientes").val();
      buscar(idClienteOriginal, null, null, null, null, null, null);
      window.location.reload();
    }

    function buscar(idCliente, idSolicitante, idAtendente, idTipoStatus, idTipoOcorrencia, statusDemanda, tituloDemanda) {

$.ajax({
 
  type: 'POST', 
  dataType: 'html',
  url: '../database/demanda.php?operacao=filtrar',
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
    tituloDemanda: tituloDemanda

  },

  success: function(msg) {
    var json = JSON.parse(msg);
    //alert("terceiro alert: " + JSON.stringify(json));
    /* alert(JSON.stringify(msg)); */
    /* $("#dados").html(msg); */

    var linha = "";
    for (var $i = 0; $i < json.length; $i++) {
      var object = json[$i];
      var dataAbertura = new Date(object.dataAbertura);
      var dataFormatada = dataAbertura.toLocaleDateString("pt-BR");

      // alert("quarto alert: " + JSON.stringify(object))
      /*  alert(object); */
      linha = linha + "<TR>";
      linha = linha + "<TD>" + object.prioridade + "</TD>";
      linha = linha + "<TD>" + object.idDemanda + "</TD>";
      linha = linha + "<TD>" + object.nomeCliente + "</TD>";
      linha = linha + "<TD>" + object.nomeSolicitante + "</TD>";
      linha = linha + "<TD>" + object.tituloDemanda + "</TD>";
      linha = linha + "<TD>" + object.nomeAtendente + "</TD>";
      linha = linha + "<TD>" + dataFormatada + "</TD>";

      linha = linha + "<TD class='"+ object.nomeTipoStatus +"' data-status='Finalizado' >" + object.nomeTipoStatus +" </TD>";

      linha = linha + "<TD>" + object.nomeTipoOcorrencia + "</TD>";
      linha = linha + "<TD>" + object.tamanho + "</TD>";
      linha = linha + "<TD>" + "<a class='btn btn-primary btn-sm' href='visualizar.php?idDemanda=" + object.idDemanda + "' role='button'><i class='bi bi-eye-fill'></i></i></a>" + "</TD>";

      linha = linha + "</TR>";
    }


    //alert(linha);
    $("#dados").html(linha);


  }
});
}


    $("#FiltroTipoStatus").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val());
    })

    $("#FiltroClientes").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val());
    })

    $("#FiltroSolicitante").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val());
    })

    $("#FiltroOcorrencia").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val());
    })

    $("#FiltroUsuario").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val());
    })

    $("#FiltroStatusDemanda").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val());
    })

    $("#buscar").click(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val());
    })

    document.addEventListener("keypress", function(e) {
      if (e.key === "Enter") {
        buscar($("#FiltroClientes").val(), $("#FiltroSolicitante").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusDemanda").val(), $("#tituloDemanda").val());
      }
    });

    $('.btnAbre').click(function() {
      $('.menuFiltros').toggleClass('mostra');
      $('.diviFrame').toggleClass('mostra');
    });
  </script>
</body>

</html>