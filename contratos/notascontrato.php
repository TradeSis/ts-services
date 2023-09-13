<?php

include_once(__DIR__ . '/../head.php');
include_once(ROOT. '/notas/database/notascontrato.php');
include_once(ROOT . '/cadastros/database/clientes.php');

$clientes = buscaClientes();
$idCliente = $contrato['idCliente'];
?>

</html>

<body class="bg-transparent">

    <nav id="menuFiltros" class="menuFiltros" style="width: 170px;margin-top: 8px;">
        <div class="titulo"><span>Filtrar por:</span></div>
        <ul>
            <!-- <li class="col-sm-12">
                <form class="d-flex" action="" method="post" style="text-align: right;">
                    <select class="form-control" name="idCliente" id="FiltroClientes" style="font-size: 14px; width: 150px; height: 35px">
                        <option value="<?php echo null ?>"><?php echo "Cliente"  ?></option>
                        <?php
                        foreach ($clientes as $cliente) {
                        ?>
                            <option <?php
                                    /*  if ($cliente['idCliente'] == $idCliente) {
                                        echo "selected";
                                    } */
                                    ?> value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente']  ?></option>
                        <?php  } ?>
                    </select>
                </form>
            </li> -->

            <li class="col-sm-12">
                <form class="d-flex" action="" method="post" style="text-align: right;">
                    <select class="form-control" name="statusNota" id="FiltroStatusNota" style="font-size: 14px; width: 150px; height: 35px">
                        <option value="<?php echo null ?>"><?php echo "statusNota"  ?></option>
                        <option value="0">Aberto</option>
                        <option value="1">Emitida</option>
                        <option value="2">Recebida</option>
                        <option value="3">Cancelada</option>
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
            <div class=" btnAbre">
                <span style="font-size: 25px;font-family: 'Material Symbols Outlined'!important;" class="material-symbols-outlined">
                    filter_alt
                </span>

            </div>

            <div class="col-sm-3 ml-2">
                <h2 class="tituloTabela">Notas Contrato</h2>
            </div>

            <div class="col-sm-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="buscanotas" placeholder="Buscar por id ou numero da nota">
                    <span class="input-group-btn">
                        <button class="btn btn-primary mt-2" id="buscar" type="button"><span style="font-size: 20px;font-family: 'Material Symbols Outlined'!important;" class="material-symbols-outlined">
                                search
                            </span></button>
                    </span>
                </div>
            </div>

            <div class="col-sm" style="text-align:right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#inserirModalNotas"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>
        </div>


        <div class="card mt-2 text-center">
            <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame">
                <table class="table">
                    <thead class="cabecalhoTabela">
                        <tr>
                            <th>idNotaServico</th>
                            <th>idCliente</th>
                            <th>dataFaturamento</th>
                            <th>dataEmissao</th>
                            <th>serieNota</th>
                            <th>numeroNota</th>
                            <th>serieRPS</th>
                            <th>numeroRPS</th>
                            <th>valorNota</th>
                            <th>statusNota</th>
                            <th>condicao</th>
                            <th colspan="2">Ação</th>
                        </tr>
                    </thead>

                    <tbody id='dados' class="fonteCorpo">

                    </tbody>
                </table>
            </div>
        </div>
    </div>


  


    <script>
        buscar($("#FiltroClientes").val(),$("#buscanotas").val(),$("#FiltroStatusNota").val());
      
        function limpar() {
            buscar(null, null, null, null);
            window.location.reload();
        }

        function buscar(idCliente, buscanotas, statusNota) {
       //alert (statusNota);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/notas/database/notasservico.php?operacao=filtrar',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    idCliente: <?php echo $idCliente ?>,
                    buscanotas: buscanotas,
                    statusNota: statusNota
                },
                success: function(msg) {

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

                        var dataFaturamentoFormatada = formatDate(object.dataFaturamento);
                        var dataEmissaoFormatada = formatDate(object.dataEmissao);

                        if (object.statusNota == 0) {
                            var novoStatusNota = "Aberto";
                        }
                        if (object.statusNota == 1) {
                            var novoStatusNota = "Emitida";
                        }
                        if (object.statusNota == 2) {
                            var novoStatusNota = "Recebida";
                        }
                        if (object.statusNota == 3) {
                            var novoStatusNota = "Cancelada";
                        }

                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.idNotaServico + "</td>";
                        linha = linha + "<td>" + object.nomeCliente + "</td>";
                        linha = linha + "<td>" + dataFaturamentoFormatada + "</td>";
                        linha = linha + "<td>" + dataEmissaoFormatada + "</td>";
                        linha = linha + "<td>" + object.serieNota + "</td>";
                        linha = linha + "<td>" + object.numeroNota + "</td>";
                        linha = linha + "<td>" + object.serieRPS + "</td>";
                        linha = linha + "<td>" + object.numeroRPS + "</td>";
                        linha = linha + "<td>" + object.valorNota + "</td>";
                        linha = linha + "<td>" + novoStatusNota + "</td>";
                        linha = linha + "<td>" + object.condicao + "</td>";
                        linha = linha + "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#alterarmodal' data-idNotaServico='" + object.idNotaServico + "'><i class='bi bi-pencil-square'></i></button>"
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        }

        $("#FiltroClientes").change(function() {
            buscar($("#FiltroClientes").val(), $("#buscanotas").val(),$("#FiltroStatusNota").val());
        })

        $("#buscar").click(function() {
            buscar($("#FiltroClientes").val(), $("#buscanotas").val(),$("#FiltroStatusNota").val());
        })

        $("#FiltroStatusNota").click(function() {
            buscar($("#FiltroClientes").val(), $("#buscanotas").val(),$("#FiltroStatusNota").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar($("#FiltroClientes").val(), $("#buscanotas").val(),$("#FiltroStatusNota").val());
            }
        });

        $(document).on('click', 'button[data-target="#alterarmodal"]', function() {
            var idNotaServico = $(this).attr("data-idNotaServico");
            //alert(idNotaServico)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/notas/database/notasservico.php?operacao=buscar',
                data: {
                    idNotaServico: idNotaServico
                },
                success: function(data) {
                    $('#idNotaServico').val(data.idNotaServico);
                    $('#idCliente').val(data.idCliente);
                    $('#dataFaturamento').val(data.dataFaturamento);
                    $('#dataEmissao').val(data.dataEmissao);
                    $('#serieNota').val(data.serieNota);
                    $('#numeroNotabd').val(data.numeroNota);
                    $('#serieRPS').val(data.serieRPS);
                    $('#numeroRPS').val(data.numeroRPS);
                    $('#valorNota').val(data.valorNota);
                    $('#statusNota').val(data.statusNota);
                    $('#condicao').val(data.condicao);
                /* alert(data) */
                    $('#alterarmodal').modal('show');
                }
            });
        });

        $('.btnAbre').click(function() {
            $('.menuFiltros').toggleClass('mostra');
            $('.diviFrame').toggleClass('mostra');
        });



        var inserirModalNotas = document.getElementById("inserirModalNotas");

        var inserirBtn = document.querySelector("button[data-target='#inserirModalNotas']");

        inserirBtn.onclick = function() {
            inserirModalNotas.style.display = "block";
        };

        window.onclick = function(event) {
            if (event.target == inserirModalNotas) {
                inserirModalNotas.style.display = "none";
            }
        };
    </script>

    <script>
        $(document).ready(function() {
            $("#inserirFormNotas").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: <?php echo URLROOT?>."/notas/database/notasservico.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#alterarFormNotas").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/notasservico.php?operacao=alterar",
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
    </script>


</body>

</html>