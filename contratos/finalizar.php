<?php
// Lucas 10022023 Melhorado estrutura do script
// Lucas 31012023  Alterado alguns campos do form: label"contrato" para "Titulo",
// Lucas 31012023  Alterado "id" para "idContrato", linhas 13, 16, 26 e 52;
// Lucas 31012023 20:55


include_once '../head.php';
include_once '../database/contratoStatus.php';
include_once '../database/clientes.php';
include_once '../database/contratos.php';

$idContrato = $_GET['idContrato'];
$contrato = buscaContratos($_GET['idContrato']);

$idCliente = $contrato["idCliente"];
$cliente = buscaClientes($idCliente);


?>

<body class="bg-transparent">

	<div class="container text-center card shadow" style="margin-top:10px">
		<div class="row">
			<div class="col card-header border-1">
				<div class="row">
					<div class="col-sm">
						<h3 class="col">Finalizar Contrato</h3>
					</div>
					<div class="col-sm" style="text-align:right">
						<a href="index.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
					</div>
				</div>
			</div>
		</div>

		<form action="../database/contratos.php?operacao=finalizar" method="post" style="margin-top: 20px; padding: 10px; text-align: left">

			<div class="row">
                <div class="col-md-6">
					<label>Titulo</label>
						<input type="text" class="form-control" name="tituloContrato" value="<?php echo $contrato['tituloContrato'] ?>" disabled>
						<input type="text" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" style="display: none">

					<div class="row" style="margin-top: 60px;">
						<div class="col">
							<label>Finalizar</label>
								<input type="datetime-local" class="form-control" name="dataFechamento" value="<?php echo $contrato['dataFechamento'] ?>">
						</div>

						<div class="col" style="margin-top: 30px;">
							<button type="submit" id="botao" class="btn btn-sm btn-danger">finalizar</button></button>
						</div>
					</div>
                </div>
						
				<div class="col-md-3">	
						<label>Cliente</label>
							<select class="form-control" name="idCliente" autocomplete="off" disabled>
								<option value="<?php echo $contrato['idCliente'] ?>"><?php echo $contrato['nomeCliente'] ?></option>
								<option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>	
							</select>
				</div>
			</div>

		</form>			
	</div>

</body>
</html>