<?php
// Lucas 20022023 adicionado o campo de Valor Contrato, linhas: 91 até 94;
// Lucas 10022023 Melhorado estrutura do script
// Lucas 01022023 - Acrescentado campos no form dataPrevisao e dataEntrega, e ajustado layout das colunas do form
// Lucas 01022023 - Retirado placeholder="Titulo do Contrato", linha 40;
// Lucas 01022023 - Ajustado label do form: idCliente, idContratoStatus, Titulo Contrato para Cliente, Status e Titulo;
// Lucas 01022023 - Removido o campo dataFechamento;
// Lucas 01022023 18:22


include '../head.php';
include '../database/contratoStatus.php';
include '../database/clientes.php';

$contratoStatusTodos = buscaContratoStatus();
$clientes = buscaClientes();

?>


<body class="bg-transparent">

    <div class="container" style="margin-top:10px; margin-bottom: 50px">
        <!-- <div class="card shadow pb-4"> -->
 
            <div class="col-sm mt-4" style="text-align:right">
                        <a href="index.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
                    </div>
                    <div class="col-sm">
                        <spam class="col titulo">Inserir Contrato</spam>
                    </div>
            <div class="container" style="margin-top: 10px">

            <form action="../database/contratos.php?operacao=inserir" method="post">
            <div class="row gy-4">

                <div class="col-md-12 form-group">

                    <label class='control-label' for='inputNormal' style="margin-top: 4px;">Titulo</label>
                    <div class="for-group">
                        <input type="text" class="form-control" name="tituloContrato" required>
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <label class="labelForm">Descrição</label>
                    <textarea class="form-control" name="descricao" autocomplete="off" rows="4"></textarea>
                </div>

                <div class="col-md-4 form-group-select">
                    <label class="labelForm">Status</label>
                    <select class="select form-control" name="idContratoStatus">
                        <?php
                        foreach ($contratoStatusTodos as $contratoStatus) {
                        ?>
                            <option value="<?php echo $contratoStatus['idContratoStatus'] ?>"><?php echo $contratoStatus['nomeContratoStatus']  ?></option>
                        <?php  } ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="labelForm">Previsão</label>
                    <input type="datetime-local" class="data select form-control" name="dataPrevisao">
                </div>

                <div class="col-md-4">
                    <label class="labelForm">Entrega</label>
                    <input type="datetime-local" class="data select form-control" name="dataEntrega">
                </div>

                <div class="col-md-3 form-group-select">
                    <label class="labelForm">Cliente</label>
                    <select class="select form-control" name="idCliente">
                        <?php
                        foreach ($clientes as $cliente) { // ABRE o 
                        ?>
                            <option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                        <?php  } ?> <!--FECHA while-->
                    </select>
                </div>

                <div class="col-md-3 form-group" style="margin-top: 6px;">
                    <label class='control-label' for='inputNormal' style="margin-top: 2px;">Horas</label>
                    <input type="number" class="form-control" name="horas" autocomplete="off" >
                </div>

                <div class="col-md-3 form-group" style="margin-top: 6px;">
                    <label class='control-label' for='inputNormal' style="margin-top: 2px;">Valor Hora</label>
                    <input type="number" class="form-control" name="valorHora" autocomplete="off" >
                </div>

                <div class="col-md-3 form-group" style="margin-top: 6px;">
                    <label class='control-label' for='inputNormal' style="margin-top: 2px;">Valor Contrato</label>
                    <input type="number" class="form-control" name="valorContrato" autocomplete="off" >
                </div>
                <div class="col-md-12 mt-4">
                    <div style="text-align:right">
                    <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
                    </div>
                </div>
                </form>
                </div>
        <!-- </div> -->
    </div>




</body>

</html>