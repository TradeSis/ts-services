<?php
// Lucas 25102023 id643 revisao geral
// Lucas 13102023 novo padrao
include_once '../header.php';
include_once '../database/contratos.php';
include_once '../database/demanda.php';

$idContrato = $_GET['idContrato'];
$demandas = buscaDemandas(null, null, $idContrato);
$horasCobrado = buscaTotalHorasCobrada($idContrato);
$horasReal = buscaTotalHorasReal($idContrato);

?>
<!doctype html>
<html lang="pt-BR">

<head>

	<?php include_once ROOT . "/vendor/head_css.php"; ?>
	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<style>
	.ts-tituloTotais{
		/* font-style: italic; */
		font-size: 13px;
	}
</style>
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
				<div class="row">
			<span class="ts-tituloTotais">Total Cobrado: <?php echo date('H:i', strtotime($horasCobrado['totalHorasCobrado'])) ?></span>
			<span class="ts-tituloTotais">Total Real: <?php echo date('H:i', strtotime($horasReal['totalHorasReal'])) ?></span>
		</div>
			</div>
			<div class="col-7">
				<!-- FILTROS -->
			
			</div>

			<div class="col-2 text-end">
			 <!-- Lucas 25102023 id643 alterado nome do target do botão para chamada do modal -->
				<button type="button" class="btn btn-success mr-4" data-bs-toggle="modal" data-bs-target="#novoinserirDemandaModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
			</div>
		</div>

		

		<div class="table mt-2 ts-divTabela70 ts-tableFiltros">
			<table class="table table-sm table-hover">
				<thead class="ts-headertabelafixo">
					<tr>
						<th></th>
						<th class="col-3">Demanda</th>
						<th>Responsável</th>
						<th>Solicitante</th>
						<th>Abertura</th>
						<th>Status</th>
						<th>Serviços</th>
						<th class="col-1">Tempo Cobrado</th>
						<th class="col-1">Tempo Real</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody class="fonteCorpo">
					<?php
					foreach ($demandas as $demanda) {
						$horas = buscaHoras($demanda['idDemanda']);

						$prioridade = $demanda['prioridade'];
						if($prioridade == '99'){
							$prioridade = '';
						  }
					?>
						<tr>
							<td class='ts-click' data-idDemanda='<?php echo $demanda['idDemanda'] ?>'><?php echo $prioridade ?></td>
							<td class='ts-click' data-idDemanda='<?php echo $demanda['idDemanda'] ?>'><?php echo $demanda['idDemanda'] ?> - <?php echo $demanda['tituloDemanda'] ?></td>
							<td class='ts-click' data-idDemanda='<?php echo $demanda['idDemanda'] ?>'><?php echo $demanda['nomeSolicitante'] ?></td>
							<td class='ts-click' data-idDemanda='<?php echo $demanda['idDemanda'] ?>'><?php echo $demanda['nomeAtendente'] ?></td>
							<td class='ts-click' data-idDemanda='<?php echo $demanda['idDemanda'] ?>'><?php echo date('d/m/Y', strtotime($demanda['dataAbertura'])) ?></td>
							<td class="ts-click <?php echo $demanda['nomeTipoStatus'] ?>" data-status='Finalizado' data-idDemanda='<?php echo $demanda['idDemanda'] ?>'><?php echo $demanda['nomeTipoStatus'] ?></td>
							<td class='ts-click' data-idDemanda='<?php echo $demanda['idDemanda'] ?>'><?php echo $demanda['nomeServico'] ?></td>
							<td class='ts-click' data-idDemanda='<?php echo $demanda['idDemanda'] ?>'><?php echo date('H:i', strtotime($demanda['tempoCobrado'])) ?></td> 
							<td class='ts-click' data-idDemanda='<?php echo $demanda['idDemanda'] ?>'><?php echo date('H:i', strtotime($horas['totalHorasReal'])) ?></td>
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
		
		 $(document).on('click', '.ts-click', function() {
        	window.location.href='../demandas/visualizar.php?idDemanda=' + $(this).attr('data-idDemanda');
    	});

	</script>

	<!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>