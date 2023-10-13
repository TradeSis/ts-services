<?php
// Lucas 13102023 novo padrao
// Lucas 20022023 adicionado o campo de Valor Contrato, linhas: 91 até 94;
// Lucas 10022023 Melhorado estrutura do script
// Lucas 01022023 - Acrescentado campos no form dataPrevisao e dataEntrega, e ajustado layout das colunas do form
// Lucas 01022023 - Retirado placeholder="Titulo do Contrato", linha 40;
// Lucas 01022023 - Ajustado label do form: idCliente, idContratoStatus, Titulo Contrato para Cliente, Status e Titulo;
// Lucas 01022023 - Removido o campo dataFechamento;
// Lucas 01022023 18:22


include '../header.php';
include '../database/contratoStatus.php';
include_once(ROOT . '/cadastros/database/clientes.php');
include '../database/contratotipos.php';

$contratoStatusTodos = buscaContratoStatus();
$clientes = buscaClientes();

$urlContratoTipo = $_GET["tipo"];
$contratoTipo = buscaContratoTipos($urlContratoTipo);
?>
<!doctype html>
<html lang="pt-BR">
<head>
    
    <?php include_once ROOT. "/vendor/head_css.php";?>

</head>



<body>

    <div class="container-fluid">

    <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Inserir <?php echo $contratoTipo['nomeContrato'] ?></h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="index.php?tipo=<?php echo $contratoTipo['idContratoTipo'] ?>" role="button" class="btn btn-primary"><i
                        class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>


            <form action="../database/contratos.php?operacao=inserir" method="post">
                <div class="row gy-4">

                    <div class="col-md-12 form-group">

                        <label class='control-label' for='inputNormal' style="margin-top: 4px;">Titulo</label>
                        <div class="for-group">
                            <input type="text" class="form-control" name="tituloContrato" required>
                            <input type="hidden" class="form-control" name="idContratoTipo" value="<?php echo $contratoTipo['idContratoTipo'] ?>">
                        </div>
                    </div>

                    <div class="container-fluid p-0">
                        <div class="col">
                            <span class="tituloEditor">Descrição</span>
                        </div>
                        <div class="quill-textarea"></div>
                        <textarea style="display: none" id="detail" name="descricao"></textarea>
                    </div>

                    <div class="col-md-4 form-group-select">
                        <label class="labelForm">Status</label>
                        <select class="select form-control" name="idContratoStatus">
                            <?php
                            foreach ($contratoStatusTodos as $contratoStatus) {
                            ?>
                                <option value="<?php echo $contratoStatus['idContratoStatus'] ?>"><?php echo $contratoStatus['nomeContratoStatus']  ?></option>
                            <?php  } ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="labelForm">Previsão</label>
                        <input type="date" class="data select form-control" name="dataPrevisao">
                    </div>

                    <div class="col-md-4">
                        <label class="labelForm">Entrega</label>
                        <input type="date" class="data select form-control" name="dataEntrega">
                    </div>

                    <div class="col-md-3 form-group-select">
                        <label class="labelForm">Cliente</label>
                        <select class="select form-control" name="idCliente">
                            <?php
                            foreach ($clientes as $cliente) { // ABRE o 
                            ?>
                                <option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                            <?php  } ?> <!--FECHA while-->
                        </select>
                    </div>

                    <div class="col-md-3 form-group" style="margin-top: 6px;">
                        <label class='control-label' for='inputNormal' style="margin-top: 2px;">Horas</label>
                        <input type="number" class="form-control" name="horas" autocomplete="off">
                    </div>

                    <div class="col-md-3 form-group" style="margin-top: 6px;">
                        <label class='control-label' for='inputNormal' style="margin-top: 2px;">Valor Hora</label>
                        <input type="number" class="form-control" name="valorHora" autocomplete="off">
                    </div>

                    <div class="col-md-3 form-group" style="margin-top: 6px;">
                        <label class='control-label' for='inputNormal' style="margin-top: 2px;">Valor Contrato</label>
                        <input type="number" class="form-control" name="valorContrato" autocomplete="off">
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="text-end mt-4">
                            <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
                        </div>
                    </div>
            </form>
       
    </div>

<!-- LOCAL PARA COLOCAR OS JS -->

<?php include_once ROOT. "/vendor/footer_js.php";?>

    <script>
        var quill = new Quill('.quill-textarea', {
    //placeholder: 'Enter Detail',
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote'],
           /*  [{
                'header': 1
            }, {
                'header': 2
            }], */ // custom button values
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            /* [{
                'script': 'sub'
            }, {
                'script': 'super'
            }], */ // superscript/subscript
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }], // outdent/indent
            [{
                'direction': 'rtl'
            }], // text direction
            [{
                'size': ['small', false, 'large', 'huge']
            }], // custom dropdown
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['link', 'image', 'video', 'formula'], // add's image support
            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            [{
                'font': []
            }],
            [{
                'align': []
            }],
            /* ['clean'] */
        ]
    }
});

quill.on('text-change', function(delta, oldDelta, source) {
    //console.log(quill.container.firstChild.innerHTML)
    $('#detail').val(quill.container.firstChild.innerHTML);
});
    </script>

     <!-- LOCAL PARA COLOCAR OS JS -FIM -->
</body>

</html>