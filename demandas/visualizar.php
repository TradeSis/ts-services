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
include_once '../database/contratos.php';
include_once '../database/tarefas.php';
include_once '../database/usuario.php';
include_once '../database/tipostatus.php';
include_once '../database/tipoocorrencia.php';
include_once '../database/servicos.php';

$idDemanda = $_GET['idDemanda'];
$ocorrencias = buscaTipoOcorrencia();
$tiposstatus = buscaTipoStatus();
$demanda = buscaDemandas($idDemanda);
$contratos = buscaContratosAbertos();
$servicos = buscaServicos();

$horas = buscaHoras($idDemanda);
$atendentes = buscaAtendente();

?>

<style>
	#tabs .tab {
		display: inline-block;

		padding: 5px 10px;
		cursor: pointer;
		position: relative;
		z-index: 5;
	}

	#tabs .whiteborder {
		border: 1px solid #707070;
		border-bottom: 1px solid #fff;
		border-radius: 3px 3px 0 0;
		color: blue;

	}

	#tabs .tabContent {
		position: relative;
		top: -1px;
		z-index: 1;
		padding: 10px;
		border-radius: 0 0 3px 3px
	}

	#tabs .hide {
		display: none;
	}

	#tabs .show {
		display: block;
	}
</style>

<body class="bg-transparent">
	<div class="container-fluid">

		<div class="col-sm mt-4" style="text-align:right">
			<a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i
					class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
		</div>
		<div class="col-sm">
			<spam class="col titulo">Chamado &#32;- &#32;
				<?php echo $idDemanda ?>
			</spam>
		</div>

		<div class="container-fluid mt-4 mb-3">
			<form action="../database/demanda.php?operacao=alterar" method="post" id="form">
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
									rows="17"><?php echo $demanda['descricao'] ?></textarea>
							</div>
						</div>

						<div class="col-md">
							<div class="col-md-12 form-group">
								<label class="labelForm">Atualização Atendente</label>
								<?php
								$dataCobradoAtualizacaoAtendente = $demanda['dataAtualizacaoAtendente'];
								if ($dataCobradoAtualizacaoAtendente != "0000-00-00 00:00:00" && $dataCobradoAtualizacaoAtendente != null) {
									$dataCobradoAtualizacaoAtendente = date('d/m/Y H:i', strtotime($dataCobradoAtualizacaoAtendente));
								}
								?>
								<input type="text" class="data select form-control" name="dataAtualizacaoAtendente"
									value="<?php echo $dataCobradoAtualizacaoAtendente ?>" readonly>
								<label class='control-label' for='inputNormal'>Data de Abertura</label>
								<input type="text" class="data select form-control" name="dataabertura"
									value="<?php echo date('d/m/Y H:i', strtotime($demanda['dataAbertura'])) ?>" readonly>
							</div>
							<div class="col-md-12 form-group" style="margin-top: -20px;">

								<label class="labelForm">Tempo Cobrado</label>
								<input type="text" class="data select form-control"
									value="<?php echo $horas['horasCobrado'] ?>" readonly>
							</div>
							<div class="col-md-12 form-group" style="margin-top: -20px;">
								<label class="labelForm">Quantidade Retornos</label>
								<input type="text" class="data select form-control"
									value="<?php echo $demanda['QtdRetornos'] ?>" readonly>
							</div>
							<div class="col-md-12 form-group" style="margin-top: -25px;">
								<label class="labelForm">Previsão</label>
								<input type="number" class="data select form-control" name="horasPrevisao"
									value="<?php echo $demanda['horasPrevisao'] ?>">
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
								$dataCobradoAtualizacaoCliente = $demanda['dataAtualizacaoCliente'];
								if ($dataCobradoAtualizacaoCliente != "0000-00-00 00:00:00" && $dataCobradoAtualizacaoCliente != null) {
									$dataCobradoAtualizacaoCliente = date('d/m/Y H:i', strtotime($dataCobradoAtualizacaoCliente));
								}
								?>
								<input type="text" class="data select form-control" name="dataAtualizacaoCliente"
									value="<?php echo $dataCobradoAtualizacaoCliente ?>" readonly>
							</div>
							<div class="col-md-12 form-group" style="margin-top: -24px;">
								<label class="labelForm">Data Fim</label>
								<?php
								$dataCobradoFechamento = $demanda['dataFechamento'];
								if ($dataCobradoFechamento != "0000-00-00 00:00:00" && $dataCobradoFechamento != null) {
									$dataCobradoFechamento = date('d/m/Y H:i', strtotime($dataCobradoFechamento));
								}
								?>
								<input type="text" class="data select form-control" name="dataFechamento"
									value="<?php echo $dataCobradoFechamento ?>" readonly>
							</div>
							<div class="col-md-12 form-group" style="margin-top: -20px;">

								<label class="labelForm">Tempo Real</label>
								<input type="text" class="data select form-control"
									value="<?php echo $horas['horasReal'] ?>" readonly>
							</div>

							<div class="col-md-12 form-group" style="margin-top: -20px;">
								<label class="labelForm">Status</label>
								<input type="text" class="data select form-control"
									value="<?php echo $demanda['nomeTipoStatus'] ?>" readonly>
							</div>

							<div class="col-md-12 form-group" style="margin-top: -25px;">
								<label class="labelForm">Ocorrência</label>
								<input type="text" class="data select form-control"
									value="<?php echo $demanda['nomeTipoOcorrencia'] ?>" readonly>
							</div>

							<div class="col-md-12 form-group-select" style="margin-top: -30px; margin-bottom: 10px">
								<label class="labelForm">Serviço</label>
								<select class="select form-control" name="idServico" autocomplete="off">
									<option value="<?php echo $demanda['idServico'] ?>"><?php echo $demanda['nomeServico'] ?></option>
									<?php foreach ($servicos as $servico) { ?>
										<option value="<?php echo $servico['idServico'] ?>"><?php echo $servico['nomeServico'] ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="col-md-12 form-group-select" style="margin-top: 10px; margin-bottom: 10px">
								<label class="labelForm">Contrato Vinculado</label>
								<select class="select form-control" name="idContrato" autocomplete="off">
									<option value="<?php echo $demanda['idContrato'] ?>"><?php echo $demanda['tituloContrato'] ?></option>
									<?php foreach ($contratos as $contrato) { ?>
										<option value="<?php echo $contrato['idContrato'] ?>"><?php echo $contrato['tituloContrato'] ?></option>
									<?php } ?>
								</select>
							</div>




						</div>
					</div>

					<div class="card-footer bg-transparent" style="margin-top: 50px;">
						<button type="submit" formaction="../database/demanda.php?operacao=validar" class="btn btn-danger "
							style="float: left;">Validar Demanda</button>
						<button type="submit" formaction="../database/demanda.php?operacao=retornar"
							class="btn btn-warning  ml-3" style="float: left;">Retornar Demanda</button>
						<input type="submit" name="submit" id="submit" class="btn btn-success" style="float: right;"
							value="Atualizar" />
						<button type="submit" formaction="../database/demanda.php?operacao=realizado"
							class="btn btn-warning" style="margin-right:20px;float: right;">Encerrar</button>
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
									rows="17"><?php echo $demanda['descricao'] ?></textarea>
							</div>
						</div>
						<div class="col-md">
							<div class="form-group">
								<label class="labelForm">Atualização Atendente</label>
								<input type="text" class="form-control" name="dataAtualizacaoAtendente"
									value="<?php echo $demanda['dataAtualizacaoAtendente'] ?>" readonly>
								<label class="labelForm">Horas Tarefa</label>
								<input type="text" class="form-control" value="<?php echo $horas['horasCobrado'] ?>"
									readonly>
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
						<button type="submit" formaction="../database/demanda.php?operacao=validar" class="btn btn-danger "
							style="float: left;">Fechar Demanda</button>
						<button type="submit" formaction="../database/demanda.php?operacao=retornar"
							class="btn btn-warning  ml-3" style="float: left;">Retornar Demanda</button>
						<input type="submit" name="submit" id="submit" class="btn btn-success" style="float: right;"
							value="Atualizar" />
					</div>
				<?php } ?>


			</form>
		</div>
		<div id="tabs" style="margin-top:40px;">
			<div class="tab whiteborder" style="margin-left:30px;">Comentarios</div>
			<div class="tab">Tarefas</div>
			<div class="tab">Previsão</div>
			<div class="tabContent">
				<?php include_once 'comentarios.php'; ?>
			</div>
			<div class="tabContent">
				<?php include_once 'visualizar_tarefa.php'; ?>
			</div>
			<div class="tabContent">
				<?php include_once 'previsao.php'; ?>
			</div>
		</div>
	</div>




</body>

</html>

<script>

	var tab;
	var tabContent;


	window.onload = function () {
		tabContent = document.getElementsByClassName('tabContent');
		tab = document.getElementsByClassName('tab');
		hideTabsContent(1);
	}

	document.getElementById('tabs').onclick = function (event) {
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