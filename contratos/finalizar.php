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

	<div class="container" style="margin-top:10px">
		

		<div class="col-sm mt-4" style="text-align:right">
                        <a href="index.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
                    </div>
                    <div class="col-sm">
                        <spam class="col titulo">Finalizar Contrato</spam>
                    </div>
            <div class="container" style="margin-top: 10px">

		<form action="../database/contratos.php?operacao=finalizar" method="post" style="margin-top: 20px; padding: 10px; text-align: left">

			<div class="row">
                <div class="col-md-8">
					<label class='labelForm'>Titulo</label>
						<input type="text" class="form-control" name="tituloContrato" value="<?php echo $contrato['tituloContrato'] ?>" disabled style="margin-top: -5px">
						<input type="text" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" style="display: none">

					<div class="row" style="margin-top: 60px;">
						<div class="col-md-4">
							<label>Finalizar</label>
								<input type="datetime-local" class="data select form_campos" name="dataFechamento" value="<?php echo $contrato['dataFechamento'] ?>">
						</div>

						<div class="col" style="margin-top: 30px;">
						<button type="submit" id="botao" class="btn btn-danger "><i class="bi bi-calendar-check"></i>&#32;Finalizar</button>
						</div>
					</div>
                </div>
						
				<div class="col-md-3" style="margin-top: -3px">	
						<label class='labelForm'>Cliente</label>
							<select class="form-control" name="idCliente" autocomplete="off" disabled style="margin-top: -5px">
								<option value="<?php echo $contrato['idCliente'] ?>"><?php echo $contrato['nomeCliente'] ?></option>
								<option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>	
							</select>
				</div>
			</div>

		</form>	
			</div>		
	</div>

	<script src="input.js"></script>
</body>
</html>