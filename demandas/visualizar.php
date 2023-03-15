<?php
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
$usuarios = buscaUsuarios($_SESSION['idUsuario']);

?>

<body class="bg-transparent">
	<div class="container mt-3">
		<div class="card shadow">

			<div class="card-header border-1">
				<div class="row">
					<div class="col-sm">
						<h3 class="col">Chamado
							<?php echo $idDemanda ?>
						</h3>
					</div>
					<div class="col-sm" style="text-align:right">
						<a href="index.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
					</div>
				</div>
			</div>


			<div class="container mt-1 mb-3">
				<form action="" method="post" id="form1">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label>Prioridade</label>
								<input type="number" min="1" max="99" class="form-control" name="prioridade" value="<?php echo $demanda['prioridade'] ?>">
							</div>
						</div>
						<div class="col-md-1">
							<div class="form-group">
								<label>ID</label>
								<input type="text" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Demanda</label>
								<input type="text" class="form-control" name="tituloDemanda" value="<?php echo $demanda['tituloDemanda'] ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Data de Abertura</label>
								<input type="text" class="form-control" name="dataabertura" value="<?php echo $demanda['dataAbertura'] ?>" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Descrição</label>
								<textarea class="form-control" name="descricao" autocomplete="off" rows="10"><?php echo $demanda['descricao'] ?></textarea>
							</div>
						</div>
						<div class="col-md">
							<div class="form-group">
								<label>Atualização Atendente</label>
								<input type="text" class="form-control" name="dataAtualizacaoAtendente" value="<?php echo $demanda['dataAtualizacaoAtendente'] ?>" readonly>
								<label>Horas Tarefa</label>
								<input type="text" class="form-control" value="<?php echo $horas['total'] ?>" readonly>
								<label>Tamanho</label>
								<select class="form-control" name="tamanho">
									<option value="P">Pequena</option>
									<option value="M">Media</option>
									<option value="G">Grande</option>
								</select>
								<label>Responsável</label>
								<select class="form-control" name="idAtendente">
									<option value="<?php echo $demanda['idAtendente'] ?>"><?php echo $demanda['nomeUsuario'] ?></option>
									<?php foreach ($atendentes as $atendente) { ?>
										<option value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md">
							<div class="form-group">
								<label>Atualização Cliente</label>
								<input type="text" class="form-control" name="dataAtualizacaoCliente" value="<?php echo $demanda['dataAtualizacaoCliente'] ?>" readonly>
								<label>Data Fim</label>
								<input type="text" class="form-control" name="dataFechamento" value="<?php echo $demanda['dataFechamento'] ?>" readonly>
								<label>Status</label>
								<select class="form-control" name="idTipoStatus" autocomplete="off">
									<option value="<?php echo $demanda['idTipoStatus'] ?>"><?php echo $demanda['nomeTipoStatus'] ?></option>
									<?php foreach ($tiposstatus as $tipostatus) { ?>
										<option value="<?php echo $tipostatus['idTipoStatus'] ?>"><?php echo $tipostatus['nomeTipoStatus'] ?></option>
									<?php } ?>
								</select>
								<label>Ocorrência</label>
								<select class="form-control" name="idTipoOcorrencia">
									<option value="<?php echo $demanda['idTipoOcorrencia'] ?>"><?php echo $demanda['nomeTipoOcorrencia'] ?></option>
									<?php foreach ($ocorrencias as $ocorrencia) { ?>
										<option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="card-footer bg-transparent">
						<button type="submit" formaction="../database/demanda.php?operacao=encerrar" class="btn btn-danger btn-sm" style="float: left;">Fechar Demanda</button>
						<button type="submit" formaction="../database/demanda.php?operacao=alterar" class="btn btn-success btn-sm" style="float: right;">Atualizar</button>
					</div>
				</form>
			</div>

			<iframe class="container-fluid" id="myIframe" src="comentarios.php?idDemanda=<?php echo $idDemanda ?>" frameborder="0" scrolling="yes" height="740"></iframe>
		</div>
	</div>


	<script type="text/javascript">
		$(document).ready(function() {

			// SELECT MENU
			$("#novoMenu a").click(function() {

				var value = $(this).text();
				value = $(this).attr('idDemanda');

				//IFRAME TAG

				$("#myIframe").attr('src', value);
			})
			// SELECT MENU
			$("#novoMenu2 a").click(function() {

				var value = $(this).text();
				value = $(this).attr('src');

				//IFRAME TAG
				if (value != '') {
					$("#myIframe").attr('src', value);
				}

			})

		});
	</script>
</body>

</html>