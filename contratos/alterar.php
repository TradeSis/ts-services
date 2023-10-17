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

</head>

<body>

	<div class="container-fluid">

		<form action="../database/contratos.php?operacao=alterar" method="post">
			<div class="row gy-4">

				<div class="col-md-1 form-group">
					<label class='control-label' for='inputNormal' style="margin-top: 4px;">ID</label>
					<input type="text" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" disabled>
				</div>
				<div class="col-md-8 form-group">
					<label class='control-label' for='inputNormal' style="margin-top: 4px;">Titulo</label>
					<input type="text" class="form-control" name="tituloContrato" value="<?php echo $contrato['tituloContrato'] ?>">
					<input type="hidden" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>">
					<input type="hidden" class="form-control" name="idContratoTipo" value="<?php echo $contrato['idContratoTipo'] ?>">
				</div>

				<div class="col-md-3 form-group mt-3">
					<label class="labelForm" style="margin-top: -20px;">Cliente</label>
					<select class="select form-control" name="idCliente" autocomplete="off" disabled>
						<option value="<?php echo $contrato['idCliente'] ?>"><?php echo $contrato['nomeCliente'] ?>
						</option>
						<option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?>
						</option>
					</select>
				</div>

				<div class="container-fluid p-0 mb-3" style="margin-top: -30px;">
					<div class="col">
						<span class="tituloEditor">Descrição</span>
					</div>
					<div class="quill-textarea"><?php echo $contrato['descricao'] ?></div>
					<textarea style="display: none" id="detail" name="descricao"><?php echo $contrato['descricao'] ?></textarea>
				</div>
				<div class="row mt-4">
					<div class="col-md-3 group-select" style="margin-top: -10px;">
						<label class="labelForm" style="margin-top: -20px;">Status</label>
						<select class="select form-control" name="idContratoStatus" autocomplete="off">
							<option value="<?php echo $contrato['idContratoStatus'] ?>"><?php echo $contrato['nomeContratoStatus'] ?></option>
							<?php
							foreach ($contratoStatusTodos as $contratoStatus) {
							?>
								<option value="<?php echo $contratoStatus['idContratoStatus'] ?>"><?php echo $contratoStatus['nomeContratoStatus'] ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="col-md-3" style="margin-top: -10px;">
						<label class="labelForm" style="margin-top: -20px;">Abertura</label>
						<input type="text" class="data select form-control" name="dataAbertura" value="<?php echo date('d/m/Y H:i', strtotime($contrato['dataAbertura'])) ?>" disabled>
					</div>


					<div class="col-md-3" style="margin-top: -10px;">
						<label class="labelForm" style="margin-top: -20px;">Previsao</label>
						<input type="date" class="data select form-control" name="dataPrevisao" value="<?php echo $contrato['dataPrevisao'] ?>">
					</div>

					<div class="col-md-3" style="margin-top: -10px;">
						<label class="labelForm" style="margin-top: -20px;">Entrega</label>
						<input type="date" class="data select form-control" name="dataEntrega" value="<?php echo $contrato['dataEntrega'] ?>">
					</div>
				</div>
			</div>

			<div class="row" style="margin-top: -30px;">
				<div class="col-md-3" style="margin-top: 20px;">
					<label class="labelForm" style="margin-top: -20px;">Fechamento</label>
					<?php if ($contrato['dataFechamento'] == null) { ?>
						<input type="text" class="data select form-control" name="dataFechamento" value="<?php echo $contrato['dataFechamento'] = '00/00/0000 00:00' ?>" disabled>
					<?php } else { ?>
						<input type="text" class="data select form-control" name="dataFechamento" value="<?php echo date('d/m/Y H:i', strtotime($contrato['dataFechamento'])) ?>" disabled>
					<?php } ?>
				</div>

				<div class="col-md-3 form-group" style="margin-top: 16px;">
					<label class="labelForm" style="margin-top: -20px;">Horas</label>
					<input type="number" class="form-control" style="margin-top: -1px;" name="horas" value="<?php echo $contrato['horas'] ?>">

				</div>

				<div class="col-md-3 form-group" style="margin-top: 16px;">
					<label class="labelForm" style="margin-top: -20px;">Valor Hora</label>
					<input type="number" class="form-control" style="margin-top: -1px;" name="valorHora" value="<?php echo $contrato['valorHora'] ?>">
				</div>

				<div class="col-md-3 form-group" style="margin-top: 16px;">
					<label class="labelForm" style="margin-top: -20px;">Valor Contrato</label>
					<input type="number" class="form-control" style="margin-top: -1px;" name="valorContrato" value="<?php echo $contrato['valorContrato'] ?>">
				</div>

			</div>
			<div class="row">
				<div class="text-end mt-4">
					<button type="submit" id="botao" class="btn btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
				</div>
			</div>
		</form>

	</div>

	<!-- LOCAL PARA COLOCAR OS JS -->

	<?php include_once ROOT . "/vendor/footer_js.php"; ?>

	<script>
		var quill = new Quill('.quill-textarea', {
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

		quill.on('text-change', function(delta, oldDelta, source) {
			$('#detail').val(quill.container.firstChild.innerHTML);
		});
	</script>

	<!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>