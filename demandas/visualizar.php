<?php
// gabriel 220323 11:19 - adicionado IF para usuario cliente, adicionado retornar demanda para cliente, recarregar pagina ao atualizar demanda
// Lucas 10032023 - alterado buscaUsuarios($logado) para buscaUsuarios($_SESSION['idUsuario']), linha 27
// gabriel 06032023 11:25 padronizado idatendente da demanda, adicionado alterar descrição
// gabriel 02032023 12:13 alteração de titulo demanda
// gabriel 06022023 adicionado contador de horas(tarefa), prioridade, data atualização atendente/cliente
// gabriel 03022023 16:00 adicionado iframe
// helio 01022023 alterado para include_once
// gabriel 01022023 15:04 - nav adicionada, comentarios.php separado
// gabriel 31012023 13:47 - nomeclaturas, botão encerrar
// helio 26012023 16:16


include_once '../head.php';
include_once '../database/demanda.php';
include_once '../database/tarefas.php';
include_once '../database/usuario.php';
include_once '../database/tipostatus.php';
include_once '../database/tipoocorrencia.php';

$idDemanda = $_GET['idDemanda'];
$ocorrencias = buscaTipoOcorrencia();
$tiposstatus = buscaTipoStatus();
$demanda = buscaDemandas($idDemanda);

$horas = buscaHoras($idDemanda);
$atendentes = buscaAtendente();

?>


<body class="bg-transparent">
	<div class="container mt-3">

		<div class="col-sm mt-4" style="text-align:right">
			<a href="index.php" role="button" class="btn btn-primary"><i
					class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
		</div>
		<div class="col-sm">
			<spam class="col titulo">Chamado &#32;- &#32;
				<?php echo $idDemanda ?>
			</spam>
		</div>

		<div class="container mt-4 mb-3">
			<form action="" method="post" id="form">
				<?php
				if ($_SESSION['idCliente'] == NULL) { ?>
					<div class="row" style="margin-right:1px;">
						<div class="col-md-1">
							<div class="form-group">
								<label class='control-label' for='inputNormal'>Prioridade</label>
								<input type="number" min="1" max="99" class="form-control" name="prioridade"
									value="<?php echo $demanda['prioridade'] ?>" style="margin-top: 50px;">
							</div>
						</div>
						<div class="col-md-1">
							<div class="form-group">
								<label class='control-label' for='inputNormal'>ID</label>
								<input type="text" class="form-control" name="idDemanda"
									value="<?php echo $demanda['idDemanda'] ?>" readonly style="margin-top: 50px;">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label class='control-label' for='inputNormal'>Demanda</label>
								<input type="text" class="form-control" name="tituloDemanda"
									value="<?php echo $demanda['tituloDemanda'] ?>" style="margin-top: 50px;">
							</div>
						</div>
						<div class="col-md-2" style="margin-top:36px;">
							<div class="form-group">
								<label class='control-label' for='inputNormal'>Solicitante</label>
								<input type="text" class="data select form-control" name="idSolicitante"
									value="<?php echo $demanda['nomeSolicitante'] ?>" readonly>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top: -30px;">
						<div class="col-md-6">
							<div class="form-group">
								<label class='labelForm'>Descrição</label>
								<textarea class="form-control" name="descricao" autocomplete="off"
									rows="12"><?php echo $demanda['descricao'] ?></textarea>
							</div>
						</div>

						<div class="col-md">
							<div class="col-md-12 form-group">
								<label class="labelForm">Atualização Atendente</label>
								<?php
								$dataAtualizacaoAtendente = $demanda['dataAtualizacaoAtendente'];
								if ($dataAtualizacaoAtendente != "0000-00-00 00:00:00") {
									$dataAtualizacaoAtendente = date('d/m/Y H:i', strtotime($dataAtualizacaoAtendente));
								}
								?>
								<input type="text" class="data select form-control" name="dataAtualizacaoAtendente"
									value="<?php echo $dataAtualizacaoAtendente ?>" readonly>
								<label class='control-label' for='inputNormal'>Data de Abertura</label>
								<input type="text" class="data select form-control" name="dataabertura"
									value="<?php echo date('d/m/Y H:i', strtotime($demanda['dataAbertura'])) ?>" readonly>
							</div>
							<div class="col-md-12 form-group" style="margin-top: -20px;">
								<label class="labelForm">Horas Tarefa</label>
								<input type="text" class="data select form-control" value="<?php echo $horas['tempo'] ?>"
									readonly>
							</div>
							<div class="col-md-12 form-group" style="margin-top: -19px;">
								<label class="labelForm">Hora Previsão</label>
								<input type="text" class="data select form-control" name="horasPrevisao" value="<?php echo $demanda['horasPrevisao'] ?>">
							</div>
							<div class="col-md-12 form-group-select" style="margin-top: -29px;">
								<label class="labelForm">Tamanho</label>
								<select class="select form-control" name="tamanho">
									<option value="<?php echo $demanda['tamanho'] ?>"><?php echo $demanda['tamanho'] ?>
									</option>
									<option value="P">P</option>
									<option value="M">M</option>
									<option value="G">G</option>
								</select>
							</div>

							<div class="col-md-12 form-group-select" style="margin-top: 20px;">
								<label class="labelForm">Responsável</label>
								<select class="select form-control" name="idAtendente">
									<option value="<?php echo $demanda['idAtendente'] ?>"><?php echo $demanda['nomeAtendente'] ?></option>
									<?php foreach ($atendentes as $atendente) { ?>
										<option value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
									<?php } ?>
								</select>
							</div>

						</div>
						<div class="col-md">
							<div class="col-md-12 form-group">
								<label class="labelForm">Atualização Cliente</label>
								<?php
								$dataAtualizacaoCliente = $demanda['dataAtualizacaoCliente'];
								if ($dataAtualizacaoCliente != "0000-00-00 00:00:00") {
									$dataAtualizacaoCliente = date('d/m/Y H:i', strtotime($dataAtualizacaoCliente));
								}
								?>
								<input type="text" class="data select form-control" name="dataAtualizacaoCliente"
									value="<?php echo $dataAtualizacaoCliente ?>" readonly>
							</div>
							<div class="col-md-12 form-group" style="margin-top: -24px;">
								<label class="labelForm">Data Fim</label>
								<?php
								$dataFechamento = $demanda['dataFechamento'];
								if ($dataFechamento != "0000-00-00 00:00:00") {
									$dataFechamento = date('d/m/Y H:i', strtotime($dataFechamento));
								}
								?>
								<input type="text" class="data select form-control" name="dataFechamento"
									value="<?php echo $dataFechamento ?>" readonly>
							</div>
							<div class="col-md-12 form-group" style="margin-top: -20px;">
								<label class="labelForm">Horas Tarefa</label>
								<input type="text" class="data select form-control" value="<?php echo $horas['duracao'] ?>"
									readonly>
							</div>

							<div class="col-md-12 form-group-select" style="margin-top: -20px;">
								<label class="labelForm">Status</label>
								<select class="select form-control" name="idTipoStatus" autocomplete="off">
									<option value="<?php echo $demanda['idTipoStatus'] ?>"><?php echo $demanda['nomeTipoStatus'] ?></option>
									<?php foreach ($tiposstatus as $tipostatus) { ?>
										<option value="<?php echo $tipostatus['idTipoStatus'] ?>"><?php echo $tipostatus['nomeTipoStatus'] ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="col-md-12 form-group-select" style="margin-top: 20px; margin-bottom: 10px">
								<label class="labelForm">Ocorrência</label>
								<select class="select form-control" name="idTipoOcorrencia">
									<option value="<?php echo $demanda['idTipoOcorrencia'] ?>"><?php echo $demanda['nomeTipoOcorrencia'] ?></option>
									<?php foreach ($ocorrencias as $ocorrencia) { ?>
										<option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?></option>
									<?php } ?>
								</select>
							</div>


						</div>
					</div>

					<div class="card-footer bg-transparent" style="margin-top: 80px;">
						<input type="submit" name="submit" id="submit" class="btn btn-success btn-sm" style="float: right;"
							value="Atualizar" />
					</div>
				<?php } //*************** visão cliente
				if ($_SESSION['idCliente'] >= 1) { ?>
					<div class="row">
						<div class="col-md-1">
							<div class="form-group">
								<label class='control-label' for='inputNormal'>Prioridade</label>
								<input type="number" min="1" max="99" class="form-control" name="prioridade"
									value="<?php echo $demanda['prioridade'] ?>" style="margin-top: 50px;">
							</div>
						</div>
						<div class="col-md-1">
							<div class="form-group">
								<label class='control-label' for='inputNormal'>ID</label>
								<input type="text" class="form-control" name="idDemanda"
									value="<?php echo $demanda['idDemanda'] ?>" readonly style="margin-top: 50px;">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class='control-label' for='inputNormal'>Demanda</label>
								<input type="text" class="form-control" name="tituloDemanda"
									value="<?php echo $demanda['tituloDemanda'] ?>" style="margin-top: 50px;">
							</div>
						</div>
						<div class="col-md-2" style="margin-top:36px;">
							<div class="form-group">
								<label class='control-label' for='inputNormal'>Solicitante</label>
								<input type="text" class="data select form-control" name="idSolicitante"
									value="<?php echo $demanda['nomeSolicitante'] ?>" readonly>
							</div>
						</div>
						<div class="col-md-2" style="margin-top:36px;">
							<div class="form-group">
								<label class='control-label' for='inputNormal'>Data de Abertura</label>
								<input type="text" class="data select form-control" name="dataabertura"
									value="<?php echo date('d/m/Y H:i', strtotime($demanda['dataAbertura'])) ?>" readonly>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top: -30px;">
						<div class="col-md-6">
							<div class="form-group">
								<label class='labelForm'>Descrição</label>
								<textarea class="form-control" name="descricao" autocomplete="off"
									rows="10"><?php echo $demanda['descricao'] ?></textarea>
							</div>
						</div>
						<div class="col-md">
							<div class="form-group">
								<label class="labelForm">Atualização Atendente</label>
								<input type="text" class="form-control" name="dataAtualizacaoAtendente"
									value="<?php echo $demanda['dataAtualizacaoAtendente'] ?>" readonly>
								<label class="labelForm">Horas Tarefa</label>
								<input type="text" class="form-control" value="<?php echo $horas['tempo'] ?>" readonly>
								<label class="labelForm">Tamanho</label>
								<input type="text" class="form-control" name="tamanho"
									value="<?php echo $demanda['tamanho'] ?>" readonly>
								<label class="labelForm">Responsável</label>
								<input type="text" class="form-control" name="idAtendente"
									value="<?php echo $demanda['nomeAtendente'] ?>" readonly>
							</div>
						</div>
						<div class="col-md">
							<div class="form-group">
								<label class="labelForm">Atualização Cliente</label>
								<input type="text" class="form-control" name="dataAtualizacaoCliente"
									value="<?php echo $demanda['dataAtualizacaoCliente'] ?>" readonly>
								<label class="labelForm">Data Fim</label>
								<input type="text" class="form-control" name="dataFechamento"
									value="<?php echo $demanda['dataFechamento'] ?>" readonly>
								<label class="labelForm">Status</label>
								<input type="text" class="form-control" name="idTipoStatus"
									value="<?php echo $demanda['nomeTipoStatus'] ?>" readonly>
								<label class="labelForm">Ocorrência</label>
								<input type="text" class="form-control" name="idTipoOcorrencia"
									value="<?php echo $demanda['nomeTipoOcorrencia'] ?>" readonly>

							</div>
						</div>
					</div>

					<div class="card-footer bg-transparent" style="margin-top: 50px;">
						<button type="submit" formaction="../database/demanda.php?operacao=encerrar" class="btn btn-danger "
							style="float: left;">Fechar Demanda</button>
						<button type="submit" formaction="../database/demanda.php?operacao=retornar"
							class="btn btn-warning  ml-3" style="float: left;">Retornar Demanda</button>
						<input type="submit" name="submit" id="submit" class="btn btn-success" style="float: right;"
							value="Atualizar" />
					</div>
				<?php } ?>

			</form>
		</div>

		<iframe class="container-fluid" id="myIframe" src="comentarios.php?idDemanda=<?php echo $idDemanda ?>"
			frameborder="0" scrolling="yes" height="740"></iframe>
		<!-- </div> -->
	</div>

	<script type="text/javascript">
		$(document).ready(function () {

			// SELECT MENU
			$("#novoMenu a").click(function () {

				var value = $(this).text();
				value = $(this).attr('idDemanda');

				//IFRAME TAG

				$("#myIframe").attr('src', value);
			})
			// SELECT MENU
			$("#novoMenu2 a").click(function () {

				var value = $(this).text();
				value = $(this).attr('src');

				//IFRAME TAG
				if (value != '') {
					$("#myIframe").attr('src', value);
				}

			})

		});
	</script>
	<script>
		$(document).ready(function () {

			$('#form').on('submit', function (event) {
				event.preventDefault();
				var form_data = $(this).serialize();

				$.ajax({
					url: "../database/demanda.php?operacao=alterar",
					method: "POST",
					data: form_data,
					dataType: "JSON",
					success: refreshPage()
				})
			});

			function refreshPage() {
				window.location.reload();
			}
		});
	</script>
</body>

</html>