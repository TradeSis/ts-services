<?php
//Lucas 22112023 id 688 - Melhorias em Demandas
//Gabriel 11102023 ID 596 mudanças em agenda e tarefas
//Gabriel 26092023 ID 575 Demandas/Comentarios - Layout de chat
//lucas 25092023 ID 358 Demandas/Comentarios
// Gabriel 22092023 id 544 Demandas - Botão Voltar
//lucas 22092023 ID 358 Demandas/Comentarios 

include_once '../header.php';
include_once '../database/demanda.php';
include_once '../database/contratos.php';
include_once '../database/tarefas.php';
include_once '../database/tipostatus.php';
include_once '../database/tipoocorrencia.php';

include_once(ROOT . '/cadastros/database/clientes.php');
include_once(ROOT . '/cadastros/database/usuario.php');
include_once(ROOT . '/cadastros/database/servicos.php');


$idDemanda = $_GET['idDemanda'];
$idAtendente = $_SESSION['idLogin'];
$ocorrencias = buscaTipoOcorrencia();
$tiposstatus = buscaTipoStatus();
$demanda = buscaDemandas($idDemanda);

if ($idDemanda !== "") {
    $tarefas = buscaTarefas($idDemanda);
    $horas = buscaHoras($idDemanda);
    $comentarios = buscaComentarios($idDemanda);
}

$servicos = buscaServicos();
$idTipoStatus = $demanda['idTipoStatus'];
$atendentes = buscaAtendente();
$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
$cliente = buscaClientes($demanda["idCliente"]);
$clientes = buscaClientes();
$contratos = buscaContratosAbertos($demanda["idCliente"]);

//Lucas 22112023 id 688 - Removido visão do cliente ($ClienteSession)


?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>


<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm mt-3 ml-4" >
                <span class="titulo">
                    <?php echo $idDemanda ?> - <?php echo $demanda['tituloDemanda'] ?>
                </span>
            </div>
         
            <div class="col-sm mt-3 text-end">
                <!-- Gabriel 22092023 id544 href dinâmico com session -->
                <?php if (isset($_SESSION['origem'])) { ?>
                    <a href="<?php echo $_SESSION['origem'] ?>" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
                <?php } ?>
            </div>
        </div>
        <div id="ts-tabs">
            <div class="tab whiteborder" id="tab-demanda">Demanda</div>
            <div class="tab" id="tab-comentarios">Comentarios</div>
            <!-- Lucas 22112023 id 688 - Removido visão do cliente -->
            <div class="tab" id="tab-tarefas">Tarefas</div>
            <div class="tab" id="tab-mensagem">mensagem</div>
            <div class="line"></div>
            <div class="tabContent">
                <?php include_once 'visualizar_demanda.php'; ?>
            </div>
            <div class="tabContent">
                <?php include_once 'comentarios.php'; ?>
            </div>
            <!-- Lucas 22112023 id 688 - Removido visão do cliente -->
            <div class="tabContent">
                <?php include_once 'visualizar_tarefa.php'; ?>
            </div>
            
            <!-- Gabriel 26092023 ID 575 adicionado tab mensagens -->
            <div class="tabContent">
                <?php 
                 /***  helio 24.10.2023 - retirado CHAT, pois estava derrubando oservidor 
                  **  include_once 'mensagem.php'; 
                    **/
                    ?>
            </div>
        </div>
    </div>

    <!--------- INSERIR/NOVA --------->
    <?php include_once 'modalTarefa_inserirAgendar.php' ?>

    <!--------- MODAL STOP --------->
    <?php include_once 'modalTarefa_stop.php' ?>
    
    <!--------- MODAL ENCERRAR --------->
    <?php include_once 'modalstatus_encerrar.php' ?>

    <!--------- MODAL REABRIR --------->
    <?php include_once 'modalstatus_reabrir.php' ?>

    <!--------- MODAL ENCAMINHAR --------->
    <?php include_once 'modalstatus_encaminhar.php' ?>

    <!--------- MODAL ENTREGAR --------->
    <?php include_once 'modalstatus_entregar.php' ?>
  
    <!--Gabriel 11102023 ID 596 modal Alterar tarefa via include -->
    <!--Lucas 18102023 ID 602 alterado nome do arquivo para modalTarefa_alterar -->
    <?php include 'modalTarefa_alterar.php'; ?>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- QUILL editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <script>
        var tab;
        var tabContent;

        window.onload = function() {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'comentarios') {
                showTabsContent(1);
            }
            if (id === 'tarefas') {
                showTabsContent(2);
            }
            //Gabriel 26092023 ID 575 adicionado tab mensagens
            if (id === 'mensagem') {
                showTabsContent(3);
            }
        }

        document.getElementById('ts-tabs').onclick = function(event) {
            var target = event.target;
            if (target.className == 'tab') {
                for (var i = 0; i < tab.length; i++) {
                    if (target == tab[i]) {
                        showTabsContent(i);
                        break;
                    }
                }
            }
        }

        function hideTabsContent(a) {
            for (var i = a; i < tabContent.length; i++) {
                tabContent[i].classList.remove('show');
                tabContent[i].classList.add("hide");
                tab[i].classList.remove('whiteborder');
            }
        }

        function showTabsContent(b) {
            if (tabContent[b].classList.contains('hide')) {
                hideTabsContent(0);
                tab[b].classList.add('whiteborder');
                tabContent[b].classList.remove('hide');
                tabContent[b].classList.add('show');
            }
        }
    </script>

    <script>
        //Lucas 10112023 ID 965 Removido script  do editor - encerrado, reabrir, encaminhar e stop        
   
        //Gabriel 11102023 ID 596 script para tratar o envio e retorno do form alterar tarefa
        $(document).ready(function() {
            $("#alterarForm").submit(function(event) {
                //alert('passou aqui')
                event.preventDefault();
                var formData = new FormData(this);
                var vurl;
                if ($("#stopButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=stop";
                }
                if ($("#startButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=start";
                }
                if ($("#realizadoButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=realizado&acao=realizado";
                }
                if ($("#atualizarButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=alterar";
                }
                $.ajax({
                    url: vurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage('tarefas', <?php echo $idDemanda ?>)

                });
            });
        });

        function refreshPage(tab, idDemanda) {
            window.location.reload();
            var url = window.location.href.split('?')[0];
            var newUrl = url + '?id=' + tab + '&&idDemanda=' + idDemanda;
            window.location.href = newUrl;
        }

        var quilldescricao = new Quill('.quill-textarea', {
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
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['link', 'image', 'video', 'formula'],
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

        quilldescricao.on('text-change', function(delta, oldDelta, source) {
            $('#quill-descricao').val(quilldescricao.container.firstChild.innerHTML);
        });
    </script>
</body>

</html>