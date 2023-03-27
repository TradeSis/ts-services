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
$usuarios = buscaUsuarios();
$tiposstatus = buscaTipoStatus();
$tipoocorrencias = buscaTipoOcorrencia();

$idCliente = null;
$idUsuario = null;
$idTipoStatus = null;
$idTipoOcorrencia = null;


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


  <div class="container-fluid pt-4">
    <div class="card shadow">
      <div class="card-header">
        <div class="row">
          <div class="col-sm">
            <h4 class="col">Demandas</h4>
          </div>

          <div class="col-sm-2 text-align:right mr-2">
            <div class="input-group">
              <input type="text" class="form-control" id="tituloDemanda" placeholder="Buscar por...">
              <span class="input-group-btn">
                <button class="btn btn-default" id="buscar" type="button"><i class="bi bi-search"></i></button>
              </span>
            </div>
          </div>

          <div class="row" style="text-align: right">

            <!--FORM CLIENTES-->
            <form class="d-flex" action="" method="post" style="text-align: right; margin-right:5px">

              <select class="form-control" name="idCliente" id="FiltroClientes">
                <option value="<?php echo null ?>"><?php echo "selecione um Cliente"  ?></option>
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

            </form>

            <!--FORM USUARIO(responsavel)-->
            <form class="d-flex" action="" method="post" style="text-align: right;">

              <select class="form-control" name="idUsuario" id="FiltroUsuario">
                <option value="<?php echo null ?>"><?php echo "selecione um Responsável"  ?></option>
                <?php
                foreach ($usuarios as $usuario) {
                ?>
                  <option <?php
                          if ($usuario['idUsuario'] == $idUsuario) {
                            echo "selected";
                          }
                          ?> value="<?php echo $usuario['idUsuario'] ?>"><?php echo $usuario['nomeUsuario']  ?></option>
                <?php  } ?>
              </select>

            </form>

            <!--FORM TIPO STATUS-->
            <form class="d-flex" action="" method="post" style="text-align: right; margin-right:5px">

              <select class="form-control" name="idTipoStatus" id="FiltroTipoStatus" autocomplete="off">
                <option value="<?php echo null ?>"><?php echo "selecione um Status"  ?></option>
                <?php foreach ($tiposstatus as $tipostatus) { ?>
                  <option <?php
                          if ($tipostatus['idTipoStatus'] == $idTipoStatus) {
                            echo "selected";
                          }
                          ?> value="<?php echo $tipostatus['idTipoStatus'] ?>"><?php echo $tipostatus['nomeTipoStatus'] ?></option>
                <?php } ?>
              </select>

            </form>

            <!--FORM TIPO OCORRÊNCIA-->
            <form class="d-flex" action="" method="post" style="text-align: right;">

              <select class="form-control" name="idTipoOcorrencia" id="FiltroOcorrencia">
                <option value="<?php echo null ?>"><?php echo "selecione uma Ocorrência"  ?></option>
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

              <div class="col-sm" style="text-align:right; color:#fff"">
                <a  onClick=" window.location.reload()" role="button" class="btn btn-success btn-sm">Limpar</a>
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
              <th>Prioridade</th>
              <th>ID</th>
              <th>Cliente</th>
              <th>Demanda</th>
              <th>Responsável</th>
              <th>Data de Abertura</th>
              <th>Status</th>
              <th>Ocorrência</th>
              <th>Tamanho</th>
              <th>Previsão</th>
              <th>Ação</th>
            </tr>
          </thead>

          <tbody id='dados'>

          </tbody>
        </table>
      </div>
    </div>
  </div>



  <script>
    buscar(null, null, null, null, null);

    function buscar(idCliente, idUsuario, idTipoStatus, idTipoOcorrencia, tituloDemanda) {
      /* alert(idCliente);
      alert(idUsuario); */
      //O método $.ajax(); é o responsável pela requisição
      $.ajax({
        //Configurações
        type: 'POST', //Método que está sendo utilizado.
        dataType: 'html', //É o tipo de dado que a página vai retornar.
        url: '../database/demanda.php?operacao=filtrar', //Indica a página que está sendo solicitada.
        //função que vai ser executada assim que a requisição for enviada
        beforeSend: function() {
          $("#dados").html("Carregando...");
        },
        data: {
          idCliente: idCliente,
          idUsuario: idUsuario,
          idTipoStatus: idTipoStatus,
          idTipoOcorrencia: idTipoOcorrencia,
          tituloDemanda: tituloDemanda

        }, //Dados para consulta
        //função que será executada quando a solicitação for finalizada.

        success: function(msg) {
          //alert("segundo alert: " + msg);
          var json = JSON.parse(msg);
          //alert("terceiro alert: " + JSON.stringify(json));
          /* alert(JSON.stringify(msg)); */
          /* $("#dados").html(msg); */

          var linha = "";
          // Loop over each object
          for (var $i = 0; $i < json.length; $i++) {
            var object = json[$i];

            // alert("quarto alert: " + JSON.stringify(object))
            /*  alert(object); */
            linha = linha + "<TR>";
            linha = linha + "<TD>" + object.prioridade + "</TD>";
            linha = linha + "<TD>" + object.idDemanda + "</TD>";
            linha = linha + "<TD>" + object.nomeCliente + "</TD>";
            linha = linha + "<TD>" + object.tituloDemanda + "</TD>";
            linha = linha + "<TD>" + object.nomeUsuario + "</TD>";
            linha = linha + "<TD>" + object.dataAbertura + "</TD>";
            linha = linha + "<TD>" + object.nomeTipoStatus + "</TD>";
            linha = linha + "<TD>" + object.nomeTipoOcorrencia + "</TD>";
            linha = linha + "<TD>" + object.tamanho + "</TD>";
            linha = linha + "<TD>" + object.horasPrevisao + "</TD>";;
            linha = linha + "<TD>" + "<a class='btn btn-primary btn-sm' href='visualizar.php?idDemanda=" + object.idDemanda + "' role='button'><i class='bi bi-eye-fill'></i></a>" + "</TD>";

            linha = linha + "</TR>";
          }


          //alert(linha);
          $("#dados").html(linha);


        }
      });
    }


    $("#FiltroTipoStatus").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#tituloDemanda").val());
    })
    //alert($("#FiltroTipoStatus").val());

    $("#FiltroClientes").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#tituloDemanda").val());
    })

    $("#FiltroOcorrencia").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#tituloDemanda").val());
    })

    $("#FiltroUsuario").change(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#tituloDemanda").val());
    })

    $("#buscar").click(function() {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#tituloDemanda").val());
    })

    document.addEventListener("keypress", function(e) {
      if (e.key === "Enter") {
        buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#FiltroTipoStatus").val(), $("#FiltroOcorrencia").val(), $("#tituloDemanda").val());
      }
    });
  </script>
</body>

</html>