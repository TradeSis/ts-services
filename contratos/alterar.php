<?php
// Lucas 13102023 novo padrao
// Lucas 20022023 alterado o type="text" para "number", linhas: 89, 95, 101
// Lucas 20022023 retirado disabled na linha 104
// Lucas 22022023 - ajustado buscaContratos parametros
// Lucas 1002023 Melhorado estrutura do script
// Lucas 31012023 - Alterado alguns campos do form: label"contrato" para "Titulo"
// Lucas 31012023 - Alterado "id" para "idContrato", linhas 13, 16, 26 e 52
// Lucas 31012023 20:55

include_once '../header.php';
include_once '../database/contratoStatus.php';
include_once(ROOT . '/cadastros/database/clientes.php');
include_once '../database/tarefas.php';
include_once(ROOT . '/cadastros/database/usuario.php');

$contratoStatusTodos = buscaContratoStatus();
$idCliente = $contrato["idCliente"];
$cliente = buscaClientes($idCliente);
$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
?>
<!doctype html>
<html lang="pt-BR">

<head>

	<?php include_once ROOT . "/vendor/head_css.php"; ?>
	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>

	<div class="container-fluid">

			<div class="container-fluid p-0 mt-3">
				<div class="col">
					<span class="tituloEditor">Descrição</span>
				</div>
				<div class="quill-textarea" style="height:300px!important"><?php echo $contrato['descricao'] ?></div>
				<textarea style="display: none" id="detail" name="descricao"><?php echo $contrato['descricao'] ?></textarea>
			</div>

	</div>

	<!-- LOCAL PARA COLOCAR OS JS -->

	<?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- QUILL editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
	<script>
		var quill = new Quill('.quill-textarea', {
			theme: 'snow',
			modules: {
				toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
             
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
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                ['link', 'image'],
                [{
                    'color': []
                }, {
                    'background': []
                }],
               
                [{
                    'align': []
                }],
            ]
			}
		});

		quill.on('text-change', function(delta, oldDelta, source) {
			$('#detail').val(quill.container.firstChild.innerHTML);
		});
	</script>

	<!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>