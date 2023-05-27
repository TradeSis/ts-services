<?php
// Lucas 16022023 criado

include_once '../head.php';
include_once '../database/seguros.php';

$recID = $_GET['recID'];
$seguros = buscaSeguros(null, null, $recID);
$seguro = $seguros[0];


?>

<body class="bg-transparent">

<div class="container text-center card shadow" style="margin-top: 10px;">
  <div class="row">
		<div class="col card-header border-1">
			<div class="row">
				<div class="col-sm" style="text-align:left">
					<h3 class="col">Seguros</h3>
				</div>

				<div class="col-sm" style="text-align:right">
					<a href="seguros.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
				</div>
			</div>
		</div>
  </div>

 

		<div class="row">

			<div class="col-6">
				<label>nomeTipoSeguro</label>
					<input type="text" class="form-control" name="nomeTipoSeguro" value="<?php echo $seguro['nomeTipoSeguro'] ?>" disabled>
			</div> 

            <div class="col-2">
				<label>codigoTipoSeguro</label>
					<input type="text" class="form-control" name="codigoTipoSeguro" value="<?php echo $seguro['codigoTipoSeguro'] ?>" disabled>
			</div> 

			<div class="col-4">
				<label>codigoFilial</label>
					<input type="text" class="form-control" name="codigoFilial" value="<?php echo $seguro['codigoFilial'] ?>" disabled>
			</div> 

			<div class="col">
				<label>codigoCliente</label>
					<input type="text" class="form-control" name="codigoCliente" value="<?php echo $seguro['codigoCliente'] ?>" disabled>
			</div>

			<div class="col">
				<label>numeroCertificado</label>
					<input type="text" class="form-control" name="numeroCertificado" value="<?php echo $seguro['numeroCertificado'] ?>" disabled>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<label>valorSeguro</label>
					<input type="text" class="form-control" name="valorSeguro" value="<?php echo $seguro['valorSeguro'] ?>" disabled>
			</div>

			<div class="col">
				<label>dataTransacao</label>
					<input type="text" class="form-control" name="dataTransacao" value="<?php echo $seguro['dataTransacao'] ?>" disabled>
			</div>

			<div class="col">
				<label>dataInicioVigencia</label>
					<input type="text" class="form-control" name="dataInicioVigencia" value="<?php echo $seguro['dataInicioVigencia'] ?>" disabled>
			</div>

            <div class="col">
				<label>dataFinalVigencia</label>
					<input type="text" class="form-control" name="dataFinalVigencia" value="<?php echo $seguro['dataFinalVigencia'] ?>" disabled>
			</div>
        </div>

        <div class="row" style="padding-bottom: 50px">
            <div class="col" >
				<label>PDF</label>
					<input type="text" class="form-control" name="PDF" value="<?php echo $seguro['PDF'] ?>" disabled>
					</div>
			<div class="col" style="margin-top: 35px; text-align:left">
				<a class="btn btn-primary btn-sm" href="<?php echo $seguro['PDF'] ?>" role="button"><i class="bi bi-filetype-pdf"></i></a>
			</div>	
			

			
        </div>


			
		</div>

    


</div><!-- container -->


</body>
</html>