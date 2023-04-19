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

function defineROOT () {

  $ROOT = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
  $ROOTex = explode("/", $ROOT);
  $ROOT = $_SERVER['DOCUMENT_ROOT']."/".$ROOTex[1];
  return $ROOT;

}


include_once('database/mysql.php');
include_once('database/api.php');




?>
