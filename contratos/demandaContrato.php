<?php
include_once '../head.php';
include_once '../database/contratos.php';
include_once '../database/demanda.php';

$idContrato = $_GET['idContrato'];
$demandas = buscaDemandas(null, null, $idContrato);
?>

<body class="bg-transparent">
    <div class="container-fluid">
        <div class="mb-2" style="text-align:right">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
        </div>
       <!--TABELA-->
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

    




    <script>
   

       /*  function refreshPage(tab, idContrato) {
            window.location.reload();
            var url = window.location.href.split('?')[0];
            var newUrl = url + '?id=' + tab + '&&idContrato=' + idContrato;
            window.location.href = newUrl;
        } */

        var inserirModal = document.getElementById("inserirModal");

        var inserirBtn = document.querySelector("button[data-target='#inserirModal']");

        inserirBtn.onclick = function () {
            inserirModal.style.display = "block";
        };

        window.onclick = function (event) {
            if (event.target == inserirModal) {
                inserirModal.style.display = "none";
            }
        };
</script>
</body>

</html>