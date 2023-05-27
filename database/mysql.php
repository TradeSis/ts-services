<?php
// helio 01022023 usando conexaoMysql com parametros de banco
// helio 01022023 retirado global conexao, criado funcao conectaMysql
function conectaMysql()
{

    $dadosConexao = defineConexaoMysql();
    $host       = $dadosConexao['host'];
    $base       = $dadosConexao['base'];
    $usuario    = $dadosConexao['usuario'];
    $senhabd    = $dadosConexao['senhadb'];

    $conexao    = mysqli_connect($host,$usuario,$senhabd,$base);
    return $conexao;

}

?>
