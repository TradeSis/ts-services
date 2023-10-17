<?php
//Lucas 13102023 novo padrao
// Gabriel 22092023 id 544 Demandas - Botão Voltar
// Lucas 22032023 ajustado função do botão de limpar
// Lucas 22032023 adicionado busca por barra de pesquisa, funcionado com pressionamento do Enter
// Lucas 15032023 alterado select de idContratoStatus para acionar uma função js, botão "buscar" foi removido, 
//  alterado botão de limpar para usar função onclick="buscar(null)"
// Lucas 15032023 Modifica a tabela ser constrida com Javascript
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


//
//

include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/contratos.php');
include_once(__DIR__ . '/../database/contratoStatus.php');
include_once(ROOT . '/cadastros/database/clientes.php');
include '../database/contratotipos.php';

$urlContratoTipo = $_GET["tipo"];
$contratoTipo = buscaContratoTipos($urlContratoTipo);

$clientes = buscaClientes();
$contratoStatusTodos = buscaContratoStatus();
$cards = buscaCards("");

$idCliente = null;
$idContratoStatus = null;
$statusContrato =  "1"; //ABERTO
if (isset($_SESSION['filtro_contrato'])) {
    $filtroEntrada = $_SESSION['filtro_contrato'];
    $idCliente = $filtroEntrada['idCliente'];
    $idContratoStatus = $filtroEntrada['idContratoStatus'];
    $statusContrato = $filtroEntrada['statusContrato'];
}

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>



<body class="bg-transparent">
    <div class="container-fluid py-1">
        <div class="header-body">
            <div class="row row-cols-6">

                <div class="col-12 col-md-12 col-lg my-2">
                    <div class="card border-left-success ts-shadow py-0 ts-cardsTotais">
                        <div class="row no-gutters align-items-center">
                            <div class="col-12 col-md-12 col-lg p-1">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase ">
                                    Total</div>

                                <div class="h5 mb-0  text-gray-800"><?php
                                                                    foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"] == "0") {
                                                                            echo "(" . $card['qtdContratos'] . ") ";
                                                                            if ("$logado" == "helio") {
                                                                                echo "R$ " . number_format((float)$card['valorContratos'], 2, ',', '');
                                                                            }
                                                                        }

                                                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg my-2">
                    <div class="card border-left-success ts-shadow py-0 ts-cardsTotais">
                        <div class="row no-gutters align-items-center">
                            <div class="col-12 col-md-12 col-lg p-1">
                                <div class="text-xs font-weight-bold text-success text-uppercase ">
                                    Orçamento</div>
                                <div class="h5 mb-0  text-gray-800"><?php
                                                                    foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"] == "1") {
                                                                            echo "(" . $card['qtdContratos'] . ") ";
                                                                            if ("$logado" == "helio") {
                                                                                echo "R$ " . number_format((float)$card['valorContratos'], 2, ',', '');
                                                                            }
                                                                        }

                                                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg my-2">
                    <div class="card border-left-success ts-shadow py-0 ts-cardsTotais">
                        <div class="row no-gutters align-items-center">
                            <div class="col-12 col-md-12 col-lg p-1 ">
                                <div class="text-xs font-weight-bold text-success text-uppercase ">
                                    Aprovação</div>
                                <div class="h5 mb-0 text-gray-800"><?php
                                                                    foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"] == "2") {
                                                                            echo "(" . $card['qtdContratos'] . ") ";
                                                                            if ("$logado" == "helio") {
                                                                                echo "R$ " . number_format((float)$card['valorContratos'], 2, ',', '');
                                                                            }
                                                                        }

                                                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg my-2">
                    <div class="card border-left-success ts-shadow py-0 ts-cardsTotais">
                        <div class="row no-gutters align-items-center">
                            <div class="col-12 col-md-12 col-lg p-1">
                                <div class="text-xs font-weight-bold text-warning text-uppercase ">
                                    Desenvolvimento</div>
                                <div class="h5 mb-0  text-gray-800"><?php
                                                                    foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"] == "3") {
                                                                            echo "(" . $card['qtdContratos'] . ") ";
                                                                            if ("$logado" == "helio") {
                                                                                echo "R$ " . number_format((float)$card['valorContratos'], 2, ',', '');
                                                                            }
                                                                        }

                                                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



                <div class="col-12 col-md-12 col-lg my-2">
                    <div class="card border-left-success ts-shadow py-0 ts-cardsTotais">
                        <div class="row no-gutters align-items-center">
                            <div class="col-12 col-md-12 col-lg p-1">
                                <div class="text-xs font-weight-bold text-danger text-uppercase ">
                                    Faturamento</div>
                                <div class="h5 mb-0  text-gray-800"><?php
                                                                    foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"] == "4") {
                                                                            echo "(" . $card['qtdContratos'] . ") ";
                                                                            if ("$logado" == "helio") {
                                                                                echo "R$ " . number_format((float)$card['valorContratos'], 2, ',', '');
                                                                            }
                                                                        }

                                                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg my-2">
                    <div class="card border-left-success ts-shadow py-0 ts-cardsTotais">
                        <div class="row no-gutters align-items-center">
                            <div class="col-12 col-md-12 col-lg p-1">
                                <div class="text-xs font-weight-bold text-danger text-uppercase ">
                                    Recebimento</div>
                                <div class="h5 mb-0  text-gray-800"><?php
                                                                    foreach ($cards as $card)
                                                                        if ($card["idContratoStatus"] == "5") {
                                                                            echo "(" . $card['qtdContratos'] . ") ";
                                                                            if ("$logado" == "helio") {
                                                                                echo "R$ " . number_format((float)$card['valorContratos'], 2, ',', '');
                                                                            }
                                                                        }

                                                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


<!-- MENUFILTROS -->
    <nav class="ts-menuFiltros" style="margin-top: 40px;"> 
    <label class="pl-2" for="">Filtrar por:</label>
       
            <div class="col-12"> <!-- ABERTO/FECHADO -->
                <form class="d-flex" action="" method="post">

                    <select class="form-control" name="statusContrato" id="FiltroStatusContrato">
                        <option value="<?php echo NULL ?>"><?php echo "Todos" ?></option>
                        <option <?php if ($statusContrato == "2") {
                                    echo "selected";
                                } ?> value="2">Orçamento</option>

                        <option <?php if ($statusContrato == "1") {
                                    echo "selected";
                                } ?> value="1">Ativo</option>

                        <option <?php if ($statusContrato == "0") {
                                    echo "selected";
                                } ?> value="0">Encerrado</option>
                    </select>

                </form>
            </div>

      

        <div class="col-sm text-end mt-2">
            <a onClick="limpar()" role=" button" class="btn btn-sm bg-info text-white">Limpar</a>
        </div>
    </nav>


    <div class="container-fluid text-center ">

        <div class="row align-items-center">
            <div class="col-6 order-1 col-sm-6  col-md-6 order-md-1 col-lg-1 order-lg-1 mt-3" >
                <button type="button" class="ts-btnFiltros btn btn-sm"><span class="material-symbols-outlined">
                        filter_alt
                    </span></button>

            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-2 order-lg-2 mt-4">
                <h2 class="ts-tituloPrincipal"><?php echo $contratoTipo['nomeContrato'] ?></h2>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-5 order-lg-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="buscaContrato" placeholder="Buscar por id ou titulo">
                    <span class="input-group-btn">
                        <button class="btn btn-primary mt-2" id="buscar" type="button"><span style="font-size: 20px;font-family: 'Material Symbols Outlined'!important;" class="material-symbols-outlined">
                                search
                            </span></button>
                    </span>
                </div>
            </div>


            <div class="col-6 order-2 col-sm-6 col-md-6 order-md-2 col-lg-4 order-lg-4 mt-1 text-end">
                <a href="inserir.php?tipo=<?php echo $contratoTipo['idContratoTipo'] ?>" role="button" class="btn btn-success mr-4"><i class="bi bi-plus-square"></i>&nbsp Novo</a>
            </div>
        </div>

        <div class="table ts-divTabela ts-tableFiltros table-striped table-hover">
            <table class="table table-sm">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th >ID</th>
                        <th >Cliente</th>
                        <th >Titulo</th>
                        <th >Status</th>
                        <th >Previsão</th>
                        <th >Entrega</th>
                        <th >Atualização</th>
                        <th >Fechamento</th>
                        <th >Horas</th>
                        <th >hora</th>
                        <th >Contrato</th>
                        <th  colspan="2">Ação</th>
                    </tr>
                    
                    <tr class="ts-headerTabelaLinhaBaixo">
                        <th ></th>
                        <th >
                            <form action="" method="post">
                                <select class="form-control ts-selectFiltrosHeaderTabela" name="idCliente" id="FiltroClientes">
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
                        <th ></th>
                        <th >
                            <form action="" method="post">
                                <select class="form-control ts-selectFiltrosHeaderTabela" name="idContratoStatus" id="FiltroContratoStatus">
                                    <option value="<?php echo null ?>"><?php echo "Status"  ?></option>
                                    <?php

                                    foreach ($contratoStatusTodos as $contratoStatus) {
                                    ?>
                                        <option <?php
                                                if ($contratoStatus['idContratoStatus'] == $idContratoStatus) {
                                                    echo "selected";
                                                }
                                                ?> value="<?php echo $contratoStatus['idContratoStatus'] ?>"><?php echo $contratoStatus['nomeContratoStatus']  ?></option>
                                    <?php  } ?>
                                </select>

                            </form>
                        </th>
                        <th ></th>
                        <th ></th>
                        <th ></th>
                        <th ></th>
                        <th ></th>
                        <th ></th>
                        <th ></th>
                        <th ></th>
                    </tr>
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

    <script>
        var urlContratoTipo = '<?php echo $urlContratoTipo ?>';
        buscar($("#FiltroClientes").val(), $("#FiltroContratoStatus").val(), $("#buscaContrato").val(), $("#FiltroStatusContrato").val());

        function limpar() {
            buscar(null, null, null, null);
            window.location.reload();
        }

        function buscar(idCliente, idContratoStatus, buscaContrato, statusContrato) {

            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/services/database/contratos.php?operacao=filtrar',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    idCliente: idCliente,
                    idContratoStatus: idContratoStatus,
                    buscaContrato: buscaContrato,
                    urlContratoTipo: urlContratoTipo,
                    statusContrato: statusContrato
                },


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
                        //dataAtualização
                        if (object.dataAtualizacao == "0000-00-00 00:00:00") {
                            var dataAtualizacaoFormatada = "<p>---</p>";
                        } else {
                            var dataAtualizacao = new Date(object.dataAtualizacao);
                            dataAtualizacaoFormatada = dataAtualizacao.toLocaleDateString("pt-BR") + " " + dataAtualizacao.toLocaleTimeString("pt-BR");
                        }

                        //dataFechamento
                        if (object.dataFechamento == null) {
                            var dataFechamentoFormatada = "<p>---</p>";
                        } else {
                            var dataFechamento = new Date(object.dataFechamento);
                            dataFechamentoFormatada = dataFechamento.toLocaleDateString("pt-BR") + " " + dataFechamento.toLocaleTimeString("pt-BR");
                        }

                        //dataPrevisao
                        if (object.dataPrevisao == "0000-00-00") {
                            var dataPrevisaoFormatada = "<p>---</p>";
                        } else {
                            var dataPrevisao = new Date(object.dataPrevisao);
                            dataPrevisaoFormatada = (`${dataPrevisao.getUTCDate().toString().padStart(2, '0')}/${(dataPrevisao.getUTCMonth()+1).toString().padStart(2, '0')}/${dataPrevisao.getUTCFullYear()}`);
                        }

                        //dataEntrega
                        if (object.dataEntrega == "0000-00-00") {
                            var dataEntregaFormatada = "<p>---</p>";
                        } else {
                            var dataEntrega = new Date(object.dataEntrega);
                            dataEntregaFormatada = (`${dataEntrega.getUTCDate().toString().padStart(2, '0')}/${(dataEntrega.getUTCMonth()+1).toString().padStart(2, '0')}/${dataEntrega.getUTCFullYear()}`);
                        }


                        // alert("quarto alert: " + JSON.stringify(object))
                        /*  alert(object); */
                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.idContrato + "</td>";
                        linha = linha + "<td>" + object.nomeCliente + "</td>";
                        linha = linha + "<td>" + object.tituloContrato + "</td>";
                        linha = linha + "<td class='" + object.nomeContratoStatus + "' data-status='Finalizado' >" + object.nomeContratoStatus + " </td>";
                        linha = linha + "<td>" + dataPrevisaoFormatada + "</td>";
                        linha = linha + "<td>" + dataEntregaFormatada + "</td>";
                        linha = linha + "<td>" + dataAtualizacaoFormatada + "</td>";
                        linha = linha + "<td>" + dataFechamentoFormatada + "</td>";
                        linha = linha + "<td>" + object.horas + "</td>";
                        linha = linha + "<td>" + object.valorHora + "</td>";
                        linha = linha + "<td>" + object.valorContrato + "</td>";
                        linha = linha + "<td>" + "<a class='btn btn-warning btn-sm' href='visualizar.php?idContrato=" + object.idContrato + "' role='button' id='visualizarDemandaButton'><i class='bi bi-pencil-square'></i></a>" + "</td>";
                        linha = linha + "</tr>";
                    }

                    //alert(linha);
                    $("#dados").html(linha);


                },
                error: function(e) {
                    alert('Erro: ' + JSON.stringify(e));

                    return null;
                }
            });

        }

        $("#FiltroClientes").change(function() {
            buscar($("#FiltroClientes").val(), $("#FiltroContratoStatus").val(), $("#buscaContrato").val(), $("#FiltroStatusContrato").val());
        })

        $("#FiltroContratoStatus").change(function() {
            buscar($("#FiltroClientes").val(), $("#FiltroContratoStatus").val(), $("#buscaContrato").val(), $("#FiltroStatusContrato").val());
        })

        $("#buscar").click(function() {
            buscar($("#FiltroClientes").val(), $("#FiltroContratoStatus").val(), $("#buscaContrato").val(), $("#FiltroStatusContrato").val());
        })

        $("#FiltroStatusContrato").click(function() {
            buscar($("#FiltroClientes").val(), $("#FiltroContratoStatus").val(), $("#buscaContrato").val(), $("#FiltroStatusContrato").val());
        })

        //Gabriel 22092023 id544 trocado setcookie por httpRequest enviado para gravar origem em session//ajax
        $(document).on('click', '#visualizarDemandaButton', function() {
            var urlContratoTipo = '?tipo=<?php echo $urlContratoTipo ?>';
            var currentPath = window.location.pathname + urlContratoTipo;
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

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar($("#FiltroClientes").val(), $("#FiltroContratoStatus").val(), $("#buscaContrato").val(), $("#FiltroStatusContrato").val());
            }
        });

    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>