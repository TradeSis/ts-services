<?php
// Lucas 09112023 ID 965 Melhorias em Tarefas
// Lucas 19102023 novo padrao
//Gabriel 11102023 ID 596 mudanças em agenda e tarefas
include_once '../header.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
        <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
        <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row align-items-center"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3 text-start">
                <!-- TITULO -->
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <?php if ($demanda['idTipoStatus'] !== TIPOSTATUS_REALIZADO && $demanda['idTipoStatus'] !== TIPOSTATUS_VALIDADO) { ?>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                <?php } ?>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela">
            <table class="table table-hover table-sm align-middle">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th class="col-1">ID</th>
                        <th class="col-5">Título</th>
                        <th class="col-1">Atendente</th>
                        <th class="col-1">Ocorrência</th>
                        <th class="col-3">Datas</th>
                        <th class="col-1" colspan="2"></th>
                    </tr>
                </thead>
                <tbody class="fonteCorpo">
                    <?php
                    //Gabriel 1102023 ID 596 removido table duplicado desnecessário
                    //Lucas 09112023 ID 965 Alterado TD
                    foreach ($tarefas as $tarefa) { 
                    ?>
                        <tr>
                            <td data-bs-toggle="modal" data-bs-target="#alterarmodal" data-idTarefa="<?php echo $tarefa['idTarefa'] ?>">
                                <?php echo $tarefa['idTarefa'] ?>
                            </td>
                            <td data-bs-toggle="modal" data-bs-target="#alterarmodal" data-idTarefa="<?php echo $tarefa['idTarefa'] ?>">
                                <?php echo $tarefa['tituloTarefa'] ?>
                            </td>
                            <td data-bs-toggle="modal" data-bs-target="#alterarmodal" data-idTarefa="<?php echo $tarefa['idTarefa'] ?>">
                                <?php echo $tarefa['nomeUsuario'] ?>
                            </td>
                            <td data-bs-toggle="modal" data-bs-target="#alterarmodal" data-idTarefa="<?php echo $tarefa['idTarefa'] ?>">
                                <?php echo $tarefa['nomeTipoOcorrencia'] ?>
                            </td>
                            <?php
                            //Lucas 09112023 ID 965 Alterado modelo de
                            //PREVISTO
                            if ($tarefa['Previsto'] != null && $tarefa['Previsto'] != "0000-00-00") {
                                $Previsto = date('d/m/Y', strtotime($tarefa['Previsto']));
                            } else {
                                $Previsto = "00/00/0000";
                            }
                            if ($tarefa['horaInicioPrevisto'] != null) {
                                $horaInicioPrevisto = date('H:i', strtotime($tarefa['horaInicioPrevisto']));
                            } else {
                                $horaInicioPrevisto = "00:00";
                            }
                            if ($tarefa['horaFinalPrevisto'] != null) {
                                $horaFinalPrevisto = date('H:i', strtotime($tarefa['horaFinalPrevisto']));
                            } else {
                                $horaFinalPrevisto = "00:00";
                            }
                            if ($tarefa['horasPrevisto'] != null) {
                                $horasPrevisto = date('H:i', strtotime($tarefa['horasPrevisto']));
                            } else {
                                $horasPrevisto = "00:00";
                            }
                             
                            //REALIZADO
                            if ($tarefa['dataReal'] != null && $tarefa['dataReal'] != "0000-00-00") {
                                $dataReal = date('d/m/Y', strtotime($tarefa['dataReal']));
                            } else {
                                $dataReal = "00/00/0000";
                            }
                            if ($tarefa['horaInicioReal'] != null) {
                                $horaInicioReal = date('H:i', strtotime($tarefa['horaInicioReal']));
                            } else {
                                $horaInicioReal = "00:00";
                            }
                            if ($tarefa['horaFinalReal'] != null) {
                                $horaFinalReal = date('H:i', strtotime($tarefa['horaFinalReal']));
                            } else {
                                $horaFinalReal = "00:00";
                            } 
                            if ($tarefa['horasReal'] != null) {
                                $horasReal = date('H:i', strtotime($tarefa['horasReal']));
                            } else {
                                $horasReal = "00:00";
                            } ?>
                            
                            <td data-bs-toggle="modal" data-bs-target="#alterarmodal" data-idTarefa="<?php echo $tarefa['idTarefa'] ?>">   
                                <?php 
                                if($tarefa['Previsto'] !== null){  
                                    echo '<span class="ts-datas ts-previsto">Prev: ' . $Previsto . '</span>'; 
                                    if($horaInicioPrevisto != "00:00"){ echo ' '. '<span class="ts-horas">'.$horaInicioPrevisto. '</span>';}else{ echo '';}
                                    if($horaFinalPrevisto != "00:00"){ echo ' '. '<span class="ts-horas">'.$horaFinalPrevisto. '</span>';}else{ echo '';}
                                    if($horasPrevisto != "00:00"){ echo ' ' . '<span class="ts-horas">'.'(' . $horasPrevisto .')'. '</span>'; }else{ echo '';}
                                    }else{ 
                                        echo ' '; 
                                } ?>  
                               
                                <br>
                                <?php 
                                if($tarefa['dataReal'] !== null){  
                                    echo '<span class="ts-datas">Real: ' . $dataReal . '</span>'; 
                                    if($horaInicioReal != "00:00"){ echo ' '. '<span class="ts-horas">'. $horaInicioReal. '</span>';}else{ echo '';}
                                    if($horaFinalReal != "00:00"){ echo ' '. '<span class="ts-horas">'. $horaFinalReal. '</span>';}else{ echo '';}
                                    if($horasReal != "00:00"){ echo ' ' . '<span class="ts-horas">'. '(' . $horasReal .')'. '</span>'; }else{ echo '';}
                                    }else{ 
                                        echo ' '; 
                                } ?>

                            </td>
                        
                            <!-- Lucas 09112023 ID 965 Alterado modelo de botões -->
                            <td>
                                <?php if ($horaInicioReal != "00:00" && $horaFinalReal == "00:00") { ?>
                                    <button type="button" class="stopButton btn btn-danger btn-sm" value="Stop" data-bs-toggle="modal" data-bs-target="#stopmodal" 
                                        data-id="<?php echo $tarefa['idTarefa'] ?>" 
                                        data-status="<?php echo $idTipoStatus ?>" 
                                        data-data-execucao="<?php echo $tarefa['horaInicioReal'] ?>" 
                                        data-demanda="<?php echo $tarefa['idDemanda'] ?>">
                                    <i class="bi bi-stop-circle"></i></button>
                                <?php } ?>
                                <?php if ($horaInicioReal == "00:00") { ?>
                                    <button type="button" class="startButton btn btn-success btn-sm" value="Start" 
                                        data-id="<?php echo $tarefa['idTarefa'] ?>" 
                                        data-status="<?php echo $idTipoStatus ?>" 
                                        data-demanda="<?php echo $tarefa['idDemanda'] ?>">
                                    <i class="bi bi-play-circle"></i></button>
                                <?php } ?>
                                <?php if (($horaInicioReal != "00:00" && $horaFinalReal != "00:00")) { ?>
                                    <button type="button" class="novoStartButton btn btn-success btn-sm" value="Start" 
                                        data-id="<?php echo $tarefa['idTarefa'] ?>" 
                                        data-titulo="<?php echo $tarefa['tituloTarefa'] ?>" 
                                        data-cliente="<?php echo $tarefa['idCliente'] ?>" 
                                        data-demanda="<?php echo $tarefa['idDemanda'] ?>" 
                                        data-atendente="<?php echo $tarefa['idAtendente'] ?>" 
                                        data-status="<?php echo $idTipoStatus ?>" 
                                        data-ocorrencia="<?php echo $tarefa['idTipoOcorrencia'] ?>" 
                                        data-statusdemanda="<?php echo $idTipoStatus ?>" 
                                        data-previsto="<?php echo $tarefa['Previsto'] ?>" 
                                        data-horainicioprevisto="<?php echo $tarefa['horaInicioPrevisto'] ?>" 
                                        data-horafinalprevisto="<?php echo $tarefa['horaFinalPrevisto'] ?>" 
                                        data-horacobrado="<?php echo $tarefa['horaCobrado'] ?>" 
                                        data-titulodemanda="<?php echo $tarefa['tituloDemanda'] ?>" 
                                        data-horainicioreal="<?php echo $tarefa['horaInicioReal'] ?>">
                                    <i class="bi bi-play-circle"></i></button>
                                <?php } ?>
                            </td>
                            <!-- Lucas 09112023 ID 965 Alterado modelo de botões -->
                            <td>
                            <div class="btn-group dropstart">
                                <button type="button" class="btn" data-toggle="tooltip" data-placement="left" title="Opções" 
                                data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow:none"><i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php if ($horaInicioReal == "00:00") { ?>
                                    <li class="ms-1 me-1 mt-1">
                                        <button type="button" class="realizadoButton btn btn-info btn-sm w-100 text-start" value="Realizado" 
                                        data-id="<?php echo $tarefa['idTarefa'] ?>" data-status="<?php echo $idTipoStatus ?>" 
                                        data-demanda="<?php echo $tarefa['idDemanda'] ?>"><i class="bi bi-check-circle"></i><span class="ts-btnAcoes"> Realizado</span></button>
                                    </li>
                                    <?php } ?>
                                    <li class="ms-1 me-1 mt-1">
                                        <button type="button" class="clonarButton btn btn-success btn-sm w-100 text-start" 
                                        data-idtarefa="<?php echo $tarefa['idTarefa'] ?>"
                                        data-idDemanda="<?php echo $tarefa['idDemanda'] ?>"
                                        ><i class='bi bi-pencil-square'></i><span class="ts-btnAcoes"> Clonar</span></button>

                                    </li>
                                    <li class="ms-1 me-1 mt-1">
                                        <button type="button" class="btn btn-warning btn-sm w-100 text-start" data-bs-toggle="modal" data-bs-target="#alterarmodal" 
                                        data-idTarefa="<?php echo $tarefa['idTarefa'] ?>"><i class='bi bi-pencil-square'></i><span class="ts-btnAcoes"> Alterar</span></button>
                                    </li>
                                </ul>
                            </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>




    <script>
        //Lucas 10112023 ID 965  Adicionado script para botão de clonar
        $(document).ready(function() {
            $(document).on('click', 'button.clonarButton', function() {
    
            var idTarefa = $(this).data("idtarefa"); 
            
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/services/database/tarefas.php?operacao=buscar',
                data: {
                    idTarefa: idTarefa
                },
                success: function(data) {
                    $('#clonartitulo').val(data.tituloTarefa);
            
                    $('#inserirModal').modal('show');
                }
                });
            });
        });

        $(document).ready(function() {
            //lucas 22092023 ID 358 Removido script do botao stop, agora o modal que faz a chamada
            $('button[data-bs-target="#stopmodal"]').click(function() {
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
                        $('#idTarefa-stop').val(data.idTarefa);
                        $('#idDemanda-stop').val(idDemanda);
                        $('#status-stop').val(status);
                        $('#horaInicioReal-stop').val(horaInicioReal);

                        $('#stopmodal').modal('show');
                    }
                });
            });
            /*lucas 22092023 ID 358 Removido script do botao stop, agora o modal que faz a chamada*/

            $('.startButton').click(function() {
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
                        //var message = msg.retorno; 
                        //alert(message);
                        if (msg.retorno == "ok") {
                            refreshPage('tarefas', idDemanda);
                        }
                    }
                });
            });

            $('.novoStartButton').click(function() {
                var idTarefa = $(this).data('id');
                var tituloTarefa = $(this).data('titulo');
                var idCliente = $(this).data('cliente');
                var idDemanda = $(this).data('demanda');
                var idAtendente = $(this).data('atendente');
                var idTipoStatus = $(this).data('status');
                var idTipoOcorrencia = $(this).data('ocorrencia');
                var tipoStatusDemanda = $(this).data('statusdemanda');
                var previsto = $(this).data('previsto');
                var horaInicioPrevisto = $(this).data('horainicioprevisto');
                var horaFinalPrevisto = $(this).data('horafinalprevisto');
                horaCobrado
                var horaCobrado = $(this).data('horacobrado');
                var tituloDemanda = $(this).data('titulodemanda');
                var horaInicioReal = $(this).data('horainicioreal');

                $.ajax({
                    url: "../database/tarefas.php?operacao=novostart",
                    method: "POST",
                    dataType: "json",
                    data: {

                        tituloTarefa: tituloTarefa,
                        idCliente: idCliente,
                        idDemanda: idDemanda,
                        idAtendente: idAtendente,
                        idTipoStatus: idTipoStatus,
                        idTipoOcorrencia: idTipoOcorrencia,
                        tipoStatusDemanda: tipoStatusDemanda,
                        Previsto: previsto,
                        horaInicioPrevisto: horaInicioPrevisto,
                        horaFinalPrevisto: horaFinalPrevisto,
                        horaCobrado: horaCobrado,
                        tituloDemanda: tituloDemanda,

                    },
                    success: function(msg) {
                        //var message = msg.retorno; 
                        //alert(message);
                        if (msg.retorno == "ok") {
                            refreshPage('tarefas', idDemanda);
                        }
                    }
                });
            });

            $('.realizadoButton').click(function() {
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
                        //var message = msg.retorno; 
                        //alert(message);
                        if (msg.retorno == "ok") {
                            refreshPage('tarefas', idDemanda);
                        }
                    }
                });
            });
            //Gabriel 1102023 ID 596 removido chamada de alterarModal

        });
        //Gabriel 1102023 ID 596 refreshPage movido para visualizar.php

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
</body>

</html>