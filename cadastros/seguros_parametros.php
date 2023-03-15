<?php
// Lucas 15022023 criado

include_once '../head.php';


?>

<body class="bg-transparent">

<div class="container text-center card shadow" style="margin-top: 10px;">
   <div class="row">
		<div class="col card-header border-1">
			<div class="row">
				<div class="col-sm" style="text-align:left">
					<h3 class="col">Busca Cliente ou Filial</h3>
				</div>
			</div>
		</div>
  </div> 

  <form action="seguros.php" method="post" style="margin-top: 20px; padding: 10px; text-align: left">


		<div class="row">
			

			<div class="col">
				<label>Codigo Filial</label>
					<input type="text" class="form-control" name="codigoFilial">
			</div> 

			<div class="col">
				<label>Codigo Cliente</label>
					<input type="text" class="form-control" name="codigoCliente">
			</div>


			<div class="col-12" style="text-align: right; padding-top: 20px">
				<button type="submit" id="botao" class="btn btn-sm btn-success">Buscar</button>
			</div>

			
		</div>

    </form>



	

</div><!-- container -->


</body>
</html>