<?php
include_once '../head.php';
include_once(ROOT. '/notas/database/notascontrato.php');


$notascontratos = buscaNotasContrato($contrato['idContrato']);
echo json_encode($notascontratos);
?>

<body class="bg-transparent">
	<div class="container-fluid">
		<div class="mb-2" style="text-align:right">
			<button type="button" class="btn btn-success mr-4" data-toggle="modal" data-target="#inserirModalNotas"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
		</div>

		<div class="card mt-2 text-center">
			<div class="table scrollbar-tabela">
				<table class="table">
					<thead class="cabecalhoTabela">
						<tr>
							<th class="text-center">ID Nota</th>
							<th class="text-center">dataFaturamento</th>
							<th class="text-center">dataEmissao</th>
							<th class="text-center">serieNota</th>
							<th class="text-center">numeroNota</th>
							<th class="text-center">serieRPS</th>
							<th class="text-center">numeroRPS</th>
							<th class="text-center">valorNota</th>
                            <th class="text-center">statusNota</th>
							<th class="text-center">Ação</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($notascontratos as $notascontrato) {
                            if($notascontrato['dataEmissao'] == "0000-00-00"){
                                $dataEmissao = "---";
                            }else{
                                $dataEmissao = date('d/m/Y', strtotime($notascontrato['dataEmissao']));
                            }
                            if($notascontrato['dataFaturamento'] == "0000-00-00"){
                                $dataFaturamento = "---";
                            }else{
                                $dataFaturamento = date('d/m/Y', strtotime($notascontrato['dataFaturamento']));
                            }
						?>
							<tr>
								<td class="text-center"><?php echo $notascontrato['idNotaServico'] ?></td>
								<td class="text-center"><?php echo $dataFaturamento ?></td>
								<td class="text-center"><?php echo $dataEmissao ?></td>
								<td class="text-center"><?php echo $notascontrato['serieNota'] ?></td>
								<td class="text-center"><?php echo $notascontrato['numeroNota'] ?></td>
								<td class="text-center"><?php echo $notascontrato['serieRPS'] ?></td>
								<td class="text-center"><?php echo $notascontrato['numeroRPS'] ?></td>
								<td class="text-center"><?php echo $notascontrato['valorNota'] ?></td>
                                <td class="text-center"><?php echo $notascontrato['statusNota'] ?></td>
								<td>
								<!-- <button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#alterarmodal' 
                                data-idContrato='79'><i class='bi bi-pencil-square'></i></button> -->	

								<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#alterarmodal' 
								data-idNotaServico='" + object.79 + "'><i class='bi bi-pencil-square'></i></button>
                                
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script>

        $(document).on('click', 'button[data-target="#alterarmodal"]', function() {
            var idNotaServico = $(this).attr("data-idNotaServico");
            //alert(idNotaServico)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/notas/database/notasservico.php?operacao=buscar',
                data: {
                    idContrato: idContrato
                },
                success: function(data) {
                    $('#idNotaServico').val(data.idNotaServico);
                    $('#idCliente').val(data.idCliente);
                    $('#dataFaturamento').val(data.dataFaturamento);
                    $('#dataEmissao').val(data.dataEmissao);
                    $('#serieNota').val(data.serieNota);
                    $('#numeroNotabd').val(data.numeroNota);
                    $('#serieRPS').val(data.serieRPS);
                    $('#numeroRPS').val(data.numeroRPS);
                    $('#valorNota').val(data.valorNota);
                    $('#statusNota').val(data.statusNota);
                    $('#condicao').val(data.condicao);
                /* alert(data) */
                    $('#alterarmodal').modal('show');
                }
            });
        });

		function refreshPage(tab, idContrato) {
			window.location.reload();
			var url = window.location.href.split('?')[0];
			var newUrl = url + '?id=' + tab + '&&idContrato=' + idContrato;
			window.location.href = newUrl;
		}

		var inserirModal = document.getElementById("inserirModal");

		var inserirBtn = document.querySelector("button[data-target='#inserirModal']");

		inserirBtn.onclick = function() {
			inserirModal.style.display = "block";
		};

		window.onclick = function(event) {
			if (event.target == inserirModal) {
				inserirModal.style.display = "none";
			}
		};
	</script>
</body>

</html>