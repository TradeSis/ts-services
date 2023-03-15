<?php
// Lucas 10032023 - substituido a variavel de $logado por $_SESSION['usuario'], nos if dos componentes cards.
// Lucas 02032023 Adicionado botão de pesquisa dentro de uma div, linha 273 
// Lucas 02032023 Adicionado height:65px, nos cards, para manter a altura, mesmo sem valor informado dentro dos cards. linhas: 55, 80, 105, 130, 157 e 182 
// Lucas 22022023 Adicionado dois modelos de teste de entrada "busca" de parametros. linhas 187 até 244 [Escolher qual melhor a ser usado]
// Lucas 22022023 Corrigido Responsividade de tamanho da tabela "formato de desktop"
// Lucas 22022023 Modificado formato dos cards
// Lucas 10022023 Corrigido estuta da tabela, coluna ação
// Lucas 10022023 Melhorado estrutura do script - parte da tabela
// Lucas 01022023 - modificação nos cads - Funciona, *melhorar o slq*
// Lucas 01022023 - Removido os campos da tabela;
// Lucas 01022023 - Adicionado campos da tabela ID, dataPrevisao e dataEntrega, alterado nome de contrato para Titulo;
// Lucas 01022023 - Adicionado os campos dataPrevisao e dataEntrega;
// Lucas 31012023 - Alterado "id" para "idContrato", linha 222;
// Lucas 31012023 - Alterado nome dos botões Alterar e Editar para Inserir e alterar;
// Lucas 31012023 20:53


include_once '../head.php';
include_once '../database/contratos.php';

include_once '../database/contratoStatus.php';
$contratoStatusTodos = buscaContratoStatus();

// 2°
$idContratoStatus = null;

//echo json_encode($_GET);

if (isset($_POST['idContratoStatus'])) {
  
  $idContratoStatus = $_POST['idContratoStatus'];
}
//echo $idContratoStatus;
$contratos = buscaContratos(null, $idContratoStatus);

$cards = buscaCards("");

?>
<style rel="stylesheet" type="text/css">
  .estilo1 {
    background-color: #2FB12B;
    border: 0px solid;
  }

  .my-custom-scrollbar {
    position: relative;
    height: 350px;
    overflow: auto;
  }
</style>

<body class="bg-transparent">
  <div class="container-fluid py-1">
    <div class="header-body">
      <div class="row row-cols-6">

        <div class="col my-2" >
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <!-- <div class="card-body"> -->
              <div class="row no-gutters align-items-center">
                <div class="col mr-2 mb-2 p-1">
                  <div class="text-xs font-weight-bold text-secondary text-uppercase ">
                  Total</div>
                  <div class="h5 mb-0  text-gray-800"><?php
                                                                      foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"]=="0"){
                                                                          echo "(".$card['qtdContratos'].") ";
                                                                          if ($_SESSION['usuario']=="helio") {
                                                                            echo "R$ ".number_format((float)$card['valorContratos'], 2, ',', '');
                                                                          }
                                                                        }
                                                                        
                                                                      ?>
                  </div>
                </div>
               
              </div>
            <!-- </div> -->
          </div>
        </div>

        <div class="col my-2" >
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <!-- <div class="card-body"> -->
              <div class="row no-gutters align-items-center">
                <div class="col mr-2 mb-2 p-1">
                  <div class="text-xs font-weight-bold text-success text-uppercase ">
                  Orçamento</div>
                  <div class="h5 mb-0  text-gray-800"><?php
                                                                      foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"]=="1"){
                                                                          echo "(".$card['qtdContratos'].") ";
                                                                          if ($_SESSION['usuario']=="helio") {
                                                                            echo "R$ ".number_format((float)$card['valorContratos'], 2, ',', '');
                                                                          }
                                                                        } 
                                                                        
                                                                      ?>
                  </div>
                </div>
               
              </div>
            <!-- </div> -->
          </div>
        </div>
        
        <div class="col my-2" >
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <!-- <div class="card-body"> -->
              <div class="row no-gutters align-items-center">
                <div class="col mr-2 mb-2 p-1 ">
                  <div class="text-xs font-weight-bold text-success text-uppercase ">
                  Aprovação</div>
                  <div class="h5 mb-0 text-gray-800"><?php
                                                                      foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"]=="2"){
                                                                          echo "(".$card['qtdContratos'].") ";
                                                                          if ($_SESSION['usuario']=="helio") {
                                                                            echo "R$ ".number_format((float)$card['valorContratos'], 2, ',', '');
                                                                          }
                                                                        }
                                                                      
                                                                      ?>
                  </div>
                </div>
               
              </div>
            <!-- </div> -->
          </div>
        </div>

        <div class="col my-2" >
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <!-- <div class="card-body"> -->
              <div class="row no-gutters align-items-center">
                <div class="col mr-2 mb-2 p-1">
                  <div class="text-xs font-weight-bold text-warning text-uppercase ">
                  Desenvolvimento</div>
                  <div class="h5 mb-0  text-gray-800"><?php
                                                                      foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"]=="3"){
                                                                          echo "(".$card['qtdContratos'].") ";
                                                                          if ($_SESSION['usuario']=="helio") {
                                                                            echo "R$ ".number_format((float)$card['valorContratos'], 2, ',', '');
                                                                          }
                                                                        }
                                                                        
                                                                      ?>
                  </div>
                </div>
               
              </div>
            <!-- </div> -->
          </div>
        </div>

       

        <div class="col my-2" >
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <!-- <div class="card-body"> -->
              <div class="row no-gutters align-items-center">
                <div class="col mr-2 mb-2 p-1">
                  <div class="text-xs font-weight-bold text-danger text-uppercase ">
                  Faturamento</div>
                  <div class="h5 mb-0  text-gray-800"><?php
                                                                      foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"]=="4"){
                                                                          echo "(".$card['qtdContratos'].") ";
                                                                          if ($_SESSION['usuario']=="helio") {
                                                                            echo "R$ ".number_format((float)$card['valorContratos'], 2, ',', '');
                                                                          }
                                                                        }
                                                                        
                                                                      ?>
                  </div>
                </div>
               
              </div>
            <!-- </div> -->
          </div>
        </div>

        <div class="col my-2" >
          <div class="card border-left-success shadow py-0" style="border-left:solid #0b2782; height:65px">
            <!-- <div class="card-body"> -->
              <div class="row no-gutters align-items-center">
                <div class="col mr-2 mb-2 p-1">
                  <div class="text-xs font-weight-bold text-danger text-uppercase ">
                  Recebimento</div>
                  <div class="h5 mb-0  text-gray-800"><?php
                                                                      foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"]=="5"){
                                                                          echo "(".$card['qtdContratos'].") ";
                                                                          if ($_SESSION['usuario'] =="helio") {
                                                                            echo "R$ ".number_format((float)$card['valorContratos'], 2, ',', '');
                                                                          }
                                                                        }
                                                                        
                                                                      ?>
                  </div>
                </div>
               
              </div>
            <!-- </div> -->
          </div>
        </div>


      </div>
    </div>
  </div>



  <div class="container-fluid text-center pt-4">
    <div class="card shadow">

<!--TEST- INICIO-->
      <div class="card-header">
        <div class="row">
          <div class="col-sm" style="text-align: left">
            <h3 class="col">Contrato</h3>
          </div>
          <div class="row" style="text-align: right">
            <!--POPUP-->
              <div class="col-sm" style="text-align:right">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                  Popup
                </button>
              </div> 

              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">

                    <div class="modal-body">
                      <form class="d-flex" action="index.php" method="post" style="text-align: right;">

                        <select class="form-control" name="idContratoStatus">
                          <?php
                          foreach ($contratoStatusTodos as $contratoStatus) {
                          ?>
                            <option  value="<?php echo $contratoStatus['idContratoStatus'] ?>"><?php echo $contratoStatus['nomeContratoStatus']  ?>
                            

                          </option>
                          <?php  } ?>
                        </select>
                        <button type="submit" id="botao" class="btn btn-xl" style="margin-right: 30px"><i class="bi bi-search"></i></button>


                      </form>
                    </div>

                  </div>
                </div>
              </div>
          <!--POPUP-->

          <form class="d-flex" id="form-pesquisa" action="" method="post" style="text-align: right;">

            <select class="form-control" name="idContratoStatus">
              <?php
              foreach ($contratoStatusTodos as $contratoStatus) {
              ?>
                <option <?php 
                              if ($contratoStatus['idContratoStatus']==$idContratoStatus)  {
                                echo "selected";
                              } 
                            ?> 
                value="<?php echo $contratoStatus['idContratoStatus'] ?>"><?php echo $contratoStatus['nomeContratoStatus']  ?></option>
              <?php  } ?>
            </select>
            <div class="col-sm ">
              <button type="submit" id="btn-pesquisar" class="btn btn-sm" style="margin-right: 10px"><i class="bi bi-search"></i>buscar</button>
          
            </div>
            <div class="col-sm" style="text-align:right">
              <a href="index.php" role="button" class="btn btn-success btn-sm">Limpar</a>
            </div>

          </form>
          </div>

          <div class="col-sm" style="text-align:right">
            <a href="inserir.php" role="button" class="btn btn-success btn-sm">Inserir Contrato</a>
          </div>
        </div>
      </div>



      <div class="table table-responsive-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar able-bordered mb-0">
        <table class="table" id="tabela"> <!-- table-striped -->
          <thead class="thead-light">
            <tr>
              <th>Cliente</th>
              <th>Titulo</th>
              <th>Status</th>
              <th>Previsão</th>
              <th>Entrega</th>
              <th>Atualização</th>
              <th>Fechamento</th>
              <th>Horas</th>
              <th>hora</th>
              <th>Contrato</th>
              <th colspan="2">Ação</th>
            </tr>
          </thead>

          <?php
          foreach ($contratos as $contrato) {
          ?>
            <tr>
              <td><?php echo $contrato['nomeCliente'] ?></td>
              <td><?php echo $contrato['tituloContrato'] ?></td>
              <td><?php echo $contrato['nomeContratoStatus'] ?></td>

              <td><?php 
              $timestamp= strtotime($contrato['dataPrevisao']);
              echo date('d/m/Y', $timestamp); 
              ?></td>

              <td><?php 
              $timestamp= strtotime($contrato['dataEntrega']);
              echo date('d/m/Y', $timestamp); 
              ?></td>

              <td><?php echo $contrato['dataAtualizacao'] ?></td>
              <td><?php echo $contrato['dataFechamento'] ?></td>
              <td><?php echo $contrato['horas'] ?></td>
              <td><?php echo $contrato['valorHora'] ?></td>
              <td><?php echo $contrato['valorContrato'] ?></td>
              <td>
                <a class="btn btn-warning btn-sm" href="alterar.php?idContrato=<?php echo $contrato['idContrato'] ?>" role="button"><i class="bi bi-pencil-square"></i></a>
              </td>
              <td>
                <a class="btn btn-danger btn-sm" href="finalizar.php?idContrato=<?php echo $contrato['idContrato'] ?>" role="button"><i class="bi bi-journal-check"></i></a>

              </td>
            </tr>
          <?php } ?>
        </table>
      </div>

    </div>
  </div>


  <script>

$( "#btn-pesquisar" ).click(function(){
  $("#tabela").refreshPage("");
});
  </script>
</body>

</html>