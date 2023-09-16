<?php
include_once(__DIR__ . '/../head.php');
$idContrato = $contrato['idContrato'];
?>

</html>

<body class="bg-transparent">

    <div class="container-fluid text-center mt-4">

        <div class="row">
            <div class="col-sm-3 ml-2">
                <h2 class="tituloTabela">Notas</h2>
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
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/notas/database/notasservico.php?operacao=buscarnotascontrato',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    idContrato:<?php echo $idContrato ?>
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
                        linha = linha + "<td>" + dataFaturamentoFormatada + "</td>";
                        linha = linha + "<td>" + dataEmissaoFormatada + "</td>";
                        linha = linha + "<td>" + object.serieNota + "</td>";
                        linha = linha + "<td>" + object.numeroNota + "</td>";
                        linha = linha + "<td>" + object.serieRPS + "</td>";
                        linha = linha + "<td>" + object.numeroRPS + "</td>";
                        linha = linha + "<td>" + object.valorNota + "</td>";
                        linha = linha + "<td>" + novoStatusNota + "</td>";
                        linha = linha + "<td>" + object.condicao + "</td>";
                        linha = linha + "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#alterarModalNotas' data-idNotaServico='" + object.idNotaServico + "'><i class='bi bi-pencil-square'></i></button>"
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        
       

        $(document).on('click', 'button[data-target="#alterarModalNotas"]', function() {
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
                    $('#nomeCliente').val(data.nomeCliente);
                    $('#dataFaturamento').val(data.dataFaturamento);
                    $('#dataEmissao').val(data.dataEmissao);
                    $('#serieNota').val(data.serieNota);
                    $('#numeroNotabd').val(data.numeroNota);
                    $('#serieRPS').val(data.serieRPS);
                    $('#numeroRPS').val(data.numeroRPS);
                    $('#valorNota').val(data.valorNota);
                    $('#statusNota').val(data.statusNota);
                    $('#condicao').val(data.condicao);
                    /* alert(data.idCliente) */
                    $('#alterarModalNotas').modal('show');
                }
            });
        });

        $('.btnAbre').click(function() {
            $('.menuFiltros').toggleClass('mostra');
            $('.diviFrame').toggleClass('mostra');
        });


      

        var inserirModal = document.getElementById("inserirModal");

        var inserirBtn = document.querySelector("button[data-target='#inserirModal']");

        inserirBtn.onclick = function() {
            inserirModal.style.display = "block";
        };

        window.onclick = function(event) {
            if (event.target == inserirModal) {
                inserirModal.style.display = "none";
            }
        };
    </script>

    <script>
        $(document).ready(function() {
            $("#inserirFormNotaContrato").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "<?php echo URLROOT?>/notas/database/notasservico.php?operacao=inserir_notascontrato",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

          $("#alterarFormNotaContrato").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "<?php echo URLROOT?>/notas/database/notasservico.php?operacao=alterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            }); 
            
         function refreshPage(tab, idContrato) {
            window.location.reload();
            var url = window.location.href.split('?')[0];
            var newUrl = url + '?id=' + tab + '&&idContrato=' + idContrato;
            window.location.href = newUrl;
            
        } 
            
        });
    </script>


</body>

</html>