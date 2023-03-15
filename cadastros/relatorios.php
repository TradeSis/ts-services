<?php
// Lucas 08022023 criado

include_once('../head.php');
include_once('../database/relatorios.php');

$relatorios = buscaRelatorios();

?>

<body class="bg-transparent">
    <div class="container" style="margin-top:10px"> 
        <div class="card shadow">
            <div class="card-header border-2">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Relatórios</h3>
                    </div>

                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">usercod</th>
                        <th class="text-center">dtinclu</th>
                        <th class="text-center">hrinclu</th>
                        <th class="text-center">progcod</th>
                        <th class="text-center">relatnom</th>
                        <th class="text-center">nomeArquivo</th>
                        <th class="text-center">REMOTE_ADDR</th>
                        

                    </tr>
                </thead>

                <?php
                foreach ($relatorios as $relatorio) {
                ?>
                    <tr>
                        <td class="text-center"><?php echo $relatorio['usercod'] ?></td>
                        <td class="text-center"><?php echo $relatorio['dtinclu'] ?></td>
                        <td class="text-center"><?php echo $relatorio['hrinclu'] ?></td>
                        <td class="text-center"><?php echo $relatorio['progcod'] ?></td>
                        <td class="text-center"><?php echo $relatorio['relatnom'] ?></td>
                        <td class="text-center"><?php echo $relatorio['nomeArquivo'] ?></td>
                        <td class="text-center"><?php echo $relatorio['REMOTE_ADDR'] ?></td>
                    </tr>
                <?php } ?>

            </table>
        </div>
    </div>


</body>

</html>