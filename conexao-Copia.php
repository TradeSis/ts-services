<?php
// helio 01022023 criado funcao defineConexao API e MySQl com aprametros locais
// helio 01022023 altereado para include_once
// helio 31012023 - include database/api
// helio 26012023 16:16

function defineConexaoApi () {
  //$apiIP = 'https://dev.tsplaces.com.br';
	$apiIP = 'http://localhost/ts';
    return $apiIP;
} 

function defineConexaoMysql () {

    $host = 'localhost';
    $base = 'tsplaces_tsservices';
    $usuario = 'root';
    $senhabd = '';

    return        array(   "host" => $host, 
                           "base" => $base,
                        "usuario" => $usuario, 
                        "senhadb" => $senhabd
                            );

}

include_once('database/mysql.php');
include_once('database/api.php');




?>
