<?php
// Lucas 20022023 alterado o type="text" para "number", linhas: 89, 95, 101
// Lucas 20022023 retirado disabled na linha 104
// Lucas 22022023 - ajustado buscaContratos parametros
// Lucas 1002023 Melhorado estrutura do script
// Lucas 31012023 - Alterado alguns campos do form: label"contrato" para "Titulo"
// Lucas 31012023 - Alterado "id" para "idContrato", linhas 13, 16, 26 e 52
// Lucas 31012023 20:55

include_once '../head.php';
include_once '../database/contratoStatus.php';
include_once(ROOT . '/cadastros/database/clientes.php');
include_once '../database/contratos.php';
include_once '../database/demanda.php';
include_once '../database/tarefas.php';
include_once(ROOT . '/cadastros/database/usuario.php');
include '../database/contratotipos.php';

$idContrato = $_GET['idContrato'];
$contratoStatusTodos = buscaContratoStatus();
$contrato = buscaContratos($idContrato, null);
$demandas = buscaDemandas(null, null, $idContrato);

$idCliente = $contrato["idCliente"];
$cliente = buscaClientes($idCliente);
$usuario = buscaUsuarios(null, $_SESSION['idLogin']);

$contratoTipo = buscaContratoTipos($contrato['idContratoTipo']);

?>


<body class="bg-transparent">

	<div class="container">


		<div class="col-sm mt-4" style="text-align:right">
			<a href="index.php?tipo=<?php echo $contratoTipo['idContratoTipo'] ?>" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
		</div>
		<div class="col-sm">
			<spam class="col titulo">Alterar <?php echo $contratoTipo['nomeContrato'] ?></spam>
		</div>

		<div class="container">

			<form action="../database/contratos.php?operacao=alterar" method="post" style="padding: 10px; text-align: left">
				<div class="row gy-4">

					<div class="col-md-12 form-group">
						<label class='control-label' for='inputNormal' style="margin-top: 4px;">Titulo</label>
						<input type="text" class="form-control" name="tituloContrato" value="<?php echo $contrato['tituloContrato'] ?>">
						<input type="text" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" style="display: none">
						<input type="text" class="form-control" name="idContratoTipo" value="<?php echo $contrato['idContratoTipo'] ?>" style="display: none">
					</div>

					<div class="container-fluid p-0 mb-3">
						<div class="col">
							<span class="tituloEditor">Descrição</span>
						</div>
						<div class="quill-textarea"><?php echo $contrato['descricao'] ?></div>
						<textarea style="display: none" id="detail" name="descricao"><?php echo $contrato['descricao'] ?></textarea>
					</div>

					<div class="col-md-3 form-group-select" style="margin-top: -10px;">
						<label class="labelForm">Status</label>
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
						<label class="labelForm">Abertura</label>
						<input type="text" class="data select form-control" name="dataAbertura" value="<?php echo date('d/m/Y H:i', strtotime($contrato['dataAbertura'])) ?>" disabled>
					</div>


					<div class="col-md-3" style="margin-top: -10px;">
						<label class="labelForm">Previsao</label>
						<input type="date" class="data select form-control" name="dataPrevisao" value="<?php echo $contrato['dataPrevisao'] ?>">
					</div>

					<div class="col-md-3" style="margin-top: -10px;">
						<label class="labelForm">Entrega</label>
						<input type="date" class="data select form-control" name="dataEntrega" value="<?php echo $contrato['dataEntrega'] ?>">
					</div>
				</div>

				<div class="row" style="margin-top: -40px;">
					<div class="col-md-3 form-group">
						<label class="labelForm">Cliente</label>
						<select class="select form-control" name="idCliente" autocomplete="off" disabled>
							<option value="<?php echo $contrato['idCliente'] ?>"><?php echo $contrato['nomeCliente'] ?>
							</option>
							<option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?>
							</option>
						</select>
					</div>

					<div class="col-md-3 form-group" style="margin-top: 16px;">
						<label class="labelForm">Horas</label>
						<input type="number" class="form-control" style="margin-top: -1px;" name="horas" value="<?php echo $contrato['horas'] ?>">

					</div>

					<div class="col-md-3 form-group" style="margin-top: 16px;">
						<label class="labelForm">Valor Hora</label>
						<input type="number" class="form-control" style="margin-top: -1px;" name="valorHora" value="<?php echo $contrato['valorHora'] ?>">
					</div>

					<div class="col-md-3 form-group" style="margin-top: 16px;">
						<label class="labelForm">Valor Contrato</label>
						<input type="number" class="form-control" style="margin-top: -1px;" name="valorContrato" value="<?php echo $contrato['valorContrato'] ?>">
					</div>

					<div class="col-12" style="text-align: right; padding-top: 10px">
						<button type="submit" id="botao" class="btn btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
					</div>

				</div>

			</form>

		</div>

		<hr style="margin-top: 30px;">
		<div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame" style="margin-left: 10px;">

			<div class="col-sm" style="text-align:right; margin-bottom: -20px">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp; Novo</button>
			</div>
			<span class="col titulo"><?php echo $contratoTipo['nomeDemanda'] ?> :</span>
			<!--------- INSERIR DEMANDA MODAL --------->
			<div class="modal fade bd-example-modal-lg" id="inserirModal" tabindex="-1" role="dialog" aria-labelledby="inserirModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Adicionar Demanda</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="container">
							<form method="post" action="../database/demanda.php?operacao=inserir_demandadecontrato" id="inserirForm">
								<div class="row">
									<div class="col-md form-group" style="margin-top: 25px;">
										<label class='control-label' for='inputNormal' style="margin-top: 4px;">Demanda</label>
										<input type="text" class="form-control" name="tituloDemanda" autocomplete="off" required>
										<input type="hidden" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" readonly>
										<input type="hidden" class="form-control" name="idContratoTipo" value="<?php echo $contrato['idContratoTipo'] ?>" readonly>
									</div>
									<div class="col-md-2 form-group-select">
										<div class="form-group">
											<label class="labelForm">Cliente</label>
											<select class="select form-control" name="idCliente" autocomplete="off" disabled>
												<option value="<?php echo $contrato['idCliente'] ?>"><?php echo $contrato['nomeCliente'] ?>
												</option>
												<option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?>
												</option>
											</select>
											<input type="hidden" class="form-control" name="idCliente" value="<?php echo $cliente['idCliente'] ?>" readonly>
											<input type="hidden" class="form-control" name="idSolicitante" value="<?php echo $usuario['idUsuario'] ?>" readonly>

										</div>
									</div>
								</div>
								<div class="row">
									<div class="col form-group">
										<label class="labelForm">Descrição</label>
										<textarea class="form-control" name="descricao" autocomplete="off" rows="10"></textarea>
									</div>
								</div>


								<div class="card-footer bg-transparent" style="text-align:right">
									<button type="submit" class="btn btn-success">Salvar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="card mt-2 text-center">
				<div class="table scrollbar-tabela">
					<table class="table">
						<thead class="cabecalhoTabela">
							<tr>
								<th class="text-center">Prioridade</th>
								<th class="text-center">ID</th>
								<th class="text-center">Solicitante</th>
								<th class="text-center">Demanda</th>
								<th class="text-center">Responsável</th>
								<th class="text-center">Abertura</th>
								<th class="text-center">Status</th>
								<th class="text-center">Ocorrência</th>
								<th class="text-center">Tamanho</th>
								<th class="text-center">Tempo</th>
								<th class="text-center">Horas Previsão</th>
								<th class="text-center">Ação</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($demandas as $demanda) {
								$horas = buscaHoras($demanda['idDemanda']);
							?>
								<tr>
									<td class="text-center"><?php echo $demanda['prioridade'] ?></td>
									<td class="text-center"><?php echo $demanda['idDemanda'] ?></td>
									<td class="text-center"><?php echo $demanda['nomeSolicitante'] ?></td>
									<td class="text-center"><?php echo $demanda['tituloDemanda'] ?></td>
									<td class="text-center"><?php echo $demanda['nomeAtendente'] ?></td>
									<td class="text-center"><?php echo date('d/m/Y', strtotime($demanda['dataAbertura'])) ?></td>
									<td class="text-center<?php echo $demanda['nomeTipoStatus'] ?>" data-status='Finalizado'><?php echo $demanda['nomeTipoStatus'] ?></td>
									<td class="text-center"><?php echo $demanda['nomeTipoOcorrencia'] ?></td>
									<td class="text-center"><?php echo $demanda['tamanho'] ?></td>
									<td class="text-center"><?php echo $horas['totalHoraCobrado'] ?></td>
									<td class="text-center"><?php echo $demanda['horasPrevisao'] ?></td>
									<td>
										<a class='btn btn-primary btn-sm' href='../demandas/visualizar.php?idDemanda=<?php echo $demanda['idDemanda'] ?>' role='button'><i class='bi bi-eye-fill'></i></i></a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	</div><!-- container -->

	<script src="<?php echo URLROOT ?>/sistema/js/quilljs.js"></script>
</body>

</html>