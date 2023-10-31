<?php
// Lucas 25102023 id643 revisao geral
// Lucas 13102023 novo padrao
include_once '../header.php';
include_once '../database/contratos.php';
include_once '../database/demanda.php';

$idContrato = $_GET['idContrato'];
$demandas = buscaDemandas(null, null, $idContrato);
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
			 <!-- Lucas 25102023 id643 alterado nome do target do botão para chamada do modal -->
				<button type="button" class="btn btn-success mr-4" data-bs-toggle="modal" data-bs-target="#novoinserirDemandaModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
			</div>
		</div>

		<div class="table mt-2 ts-divTabela">
			<table class="table table-hover table-sm text-center">
				<thead class="ts-headertabelafixo">
					<tr>
						<th>Prioridade</th>
						<th>ID</th>
						<th>Solicitante</th>
						<th>Demanda</th>
						<th>Responsável</th>
						<th>Abertura</th>
						<th>Status</th>
						<th>Ocorrência</th>
						<th>Ação</th>
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
							<td>
								<a class='btn btn-warning btn-sm' href='../demandas/visualizar.php?idDemanda=<?php echo $demanda['idDemanda'] ?>' role='button'><i class='bi bi-pencil-square'></i></i></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

	</div>

	<!-- LOCAL PARA COLOCAR OS JS -->

	<?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- QUILL editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
	<script>
	/* 	function refreshPage(tab, idContrato) {
			window.location.reload();
			var url = window.location.href.split('?')[0];
			var newUrl = url + '?id=' + tab + '&&idContrato=' + idContrato;
			window.location.href = newUrl;
		}

		var inserirModal = document.getElementById("inserirDemandaContratoModal");

		var inserirBtn = document.querySelector("button[data-target='#inserirDemandaContratoModal']");

		inserirBtn.onclick = function() {
			inserirModal.style.display = "block";
		};

		window.onclick = function(event) {
			if (event.target == inserirModal) {
				inserirModal.style.display = "none";
			}
		}; */
	</script>

	<!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>