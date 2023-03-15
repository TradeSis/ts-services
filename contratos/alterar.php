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
include_once '../database/clientes.php';
include_once '../database/contratos.php';

$idContrato = $_GET['idContrato'];
$contratoStatusTodos = buscaContratoStatus();
$contrato = buscaContratos($idContrato, null);

$idCliente = $contrato["idCliente"];
$cliente = buscaClientes($idCliente);

?>

<body class="bg-transparent">

<div class="container text-center card shadow" style="margin-top: 10px;">
  <div class="row">
		<div class="col card-header border-1">
			<div class="row">
				<div class="col-sm" style="text-align:left">
					<h3 class="col">Alterar Contrato</h3>
				</div>

				<div class="col-sm" style="text-align:right">
					<a href="index.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
				</div>
			</div>
		</div>
  </div>

  <form action="../database/contratos.php?operacao=alterar" method="post" style="margin-top: 20px; padding: 10px; text-align: left">
		<div class="row">
			<label>Titulo</label>
				<input type="text" class="form-control" name="tituloContrato" value="<?php echo $contrato['tituloContrato'] ?>">
				<input type="text" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" style="display: none">
			<label>Descrição</label>
				<textarea class="form-control" name="descricao" autocomplete="off" rows="4"><?php echo $contrato['descricao'] ?></textarea>
		</div>

		<div class="row">
			<div class="col">
				<label>Status</label>
					<select class="form-control" name="idContratoStatus" autocomplete="off">
						<option value="<?php echo $contrato['idContratoStatus'] ?>"><?php echo $contrato['nomeContratoStatus'] ?></option>
								<?php
								foreach ($contratoStatusTodos as $contratoStatus) {
								?>
									<option value="<?php echo $contratoStatus['idContratoStatus'] ?>"><?php echo $contratoStatus['nomeContratoStatus'] ?></option>
								<?php } ?>
					</select>
			</div>

			<div class="col">
				<label>Abertura</label>
					<input type="text" class="form-control" name="dataAbertura" value="<?php echo $contrato['dataAbertura'] ?>" disabled>
			</div> 

			<div class="col">
				<label>Previsao</label>
					<input type="datetime-local" class="form-control" name="dataPrevisao" value="<?php echo $contrato['dataPrevisao'] ?>">
			</div>

			<div class="col">
				<label>Entrega</label>
					<input type="datetime-local" class="form-control" name="dataEntrega" value="<?php echo $contrato['dataEntrega'] ?>">
			</div>
		</div>

		<div class="row">
			<div class="col-4">
				<label>Cliente</label>
					<select class="form-control" name="idCliente" autocomplete="off" disabled>
						<option value="<?php echo $contrato['idCliente'] ?>"><?php echo $contrato['nomeCliente'] ?></option>
						<option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>			
					</select>
			</div>

			<div class="col-2">
				<label>Horas</label>
					<input type="number" class="form-control" name="horas" value="<?php echo $contrato['horas'] ?>">

			</div>

			<div class="col-2">
				<label>Valor Hora</label>
					<input type="number" class="form-control" name="valorHora" value="<?php echo $contrato['valorHora'] ?>">
			</div>

			<div class="col-2">
				<label>Valor Contrato</label>
					<input type="number" class="form-control" name="valorContrato" value="<?php echo $contrato['valorContrato'] ?>">
			</div>

			<div class="col-12" style="text-align: right; padding-top: 20px">
				<button type="submit" id="botao" class="btn btn-sm btn-success">Salvar</button>
			</div>

			
		</div>

    </form>

	
	<div class="row border-1">
		<div class="row">
			<div class="col-sm">
				<h5 class="col">Finalizar Contrato</h5>
			</div>
		</div>

	</div>	

	<form action="../database/contratos.php?operacao=finalizar" method="post" style="margin-top:30px;">
		<div class="row" style="padding-bottom: 50px;">
			<div class="col-3">
				<input type="text" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" style="display: none">
				<input type="datetime-local" class="form-control" name="dataFechamento" value="<?php echo $contrato['dataFechamento'] ?>">
			</div>

			<div class="col-3" style="text-align: left;">
				<button type="submit" id="botao" class="btn btn-sm btn-danger "><i class="bi bi-journal-check"></i> Finalizar</button>
			</div>
		</div>					
	</form>
		

	

</div><!-- container -->


</body>
</html>
