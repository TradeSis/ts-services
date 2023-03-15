<?php
// Lucas 15022023 criado

include_once('../head.php');
include_once('../database/seguros.php');

/* $seguros = buscaSeguros(); */
//echo json_encode($seguros);


$codigoCliente = $_POST['codigoCliente'];
$codigoFilial = $_POST['codigoFilial'];
    


if (empty($codigoCliente)) {
    $codigoCliente = null;
} // Se estiver vazio, coloca null
if (empty($codigoFilial)) {
    $codigoFilial = null;
} // Se estiver vazio, coloca null
$recID = null;

$seguros = buscaSeguros($codigoCliente, $codigoFilial, $recID);
//echo json_encode($seguros);
?>

<body class="bg-transparent">

<div class="container-fluid text-center">
    <div class="card shadow">

      <div class="card-header">
        <div class="row" >
                <div class="col-sm" style="text-align: left;">
                    <h3 class="col">Seguros</h3>
                </div>
            </div>
      </div>

      <div class="table-responsive-sm">
        <table class="table table-sm table-hover table-bordered mb-0">
          <thead class="thead-light">
            <tr>
            
                <th>recID</th>
                <th>codigoTipoSeguro</th>
                <th>nomeTipoSeguro</th>
                <th>codigoFilial</th>
                <th>codigoCliente</th>
                <th>numeroCertificado</th>
                <th>valorSeguro</th>
                <th>dataTransacao</th>
                <th>dataInicioVigencia</th>
                <th>dataFinalVigencia</th>
                <th>PDF</th>
                <th>Ação</th>
                        
            </tr>
          </thead>

          <?php
                foreach ($seguros as $seguro) {
            ?>
                <tr> 
                    
                    <td><?php echo $seguro['recID'] ?></td>
                    <td><?php echo $seguro['codigoTipoSeguro'] ?></td>
                    <td><?php echo $seguro['nomeTipoSeguro'] ?></td>    
                    <td><?php echo $seguro['codigoFilial'] ?></td> 
                    <td><?php echo $seguro['codigoCliente'] ?></td> 
                    <td><?php echo $seguro['numeroCertificado'] ?></td> 
                    <td><?php echo $seguro['valorSeguro'] ?></td>           
                    <td><?php echo $seguro['dataTransacao'] ?></td> 
                    <td><?php echo $seguro['dataInicioVigencia'] ?></td> 
                    <td><?php echo $seguro['dataFinalVigencia'] ?></td> 
                    <td><a class="btn btn-primary btn-sm" href="<?php echo $seguro['PDF'] ?>" role="button"><i class="bi bi-filetype-pdf"></i></a></td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="seguros_vizualizar.php?recID=<?php echo $seguro['recID'] ?>" role="button">Visualizar</a>
                    </td>
                </tr>
                    <?php } ?>
        </table>
      </div>
    </div>
  
</div>

    <div div class="col-sm" style="text-align:right; margin-top:30px">
		<a href="seguros_parametros.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
    </div>


  </body>

 