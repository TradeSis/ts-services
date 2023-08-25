<?php
// Lucas 05042023 - adicionado aplicativo, menu, menuPrograma e montaMenu
// gabriel 200323 11:04 - demanda/retornar
// Lucas 03032023 - usuario alterar
// Helio 16022023 - contrato/totais
// Lucas 06022023 - adicionado contratoStatus (GET)
// helio 31012023 - melhorar testes de metodos, incluido clientes_inserir (POST)
// helio 26012023 18:10

//echo "metodo=".$metodo."\n";
//echo "funcao=".$funcao."\n";
//echo "parametro=".$parametro."\n";

if ($metodo == "GET") {

  if ($funcao == "contrato" && $parametro == "totais") {
    $funcao = "contrato/totais";
    $parametro = null;
  }

  if ($funcao == "demandas" && $parametro == "totais") {
    $funcao = "demandas/totais";
    $parametro = null;
  }

  if ($funcao == "tarefas" && $parametro == "grafico1") {
    $funcao = "tarefas/grafico1";
    $parametro = null;
  }

  if ($funcao == "tarefas" && $parametro == "grafico2") {
    $funcao = "tarefas/grafico2";
    $parametro = null;
  }

  if ($funcao == "tarefas" && $parametro == "grafico3") {
    $funcao = "tarefas/grafico3";
    $parametro = null;
  }

  if ($funcao == "tarefas" && $parametro == "grafico4") {
    $funcao = "tarefas/grafico4";
    $parametro = null;
  }

  switch ($funcao) {
    case "contratostatus":
      include 'contratostatus.php';
      break;

    case "tipostatus":
      include 'tipostatus.php';
      break;

    case "tipoocorrencia":
      include 'tipoocorrencia.php';
      break;

    case "contrato":

      include 'contrato.php';
      break;

    case "demanda":
      include 'demanda.php';
      break;

    case "usuario":
      include 'usuario.php';
      break;

    case "tarefas":
      include 'tarefas.php';
      break;

    case "comentario":
      include 'comentario.php';
      break;

    case "horas":
      include 'tarefas_horas.php';
      break;

    case "contrato/totais":
      include 'contrato_totais.php';
      break;

    case "demandas/totais":
      include 'demandas_totais.php';
      break;

    case "usuario/verifica":
      include 'usuario_verifica.php';
      break;

    case "tarefas/grafico1":
      include 'tarefas_grafico1.php';
      break;

    case "tarefas/grafico2":
      include 'tarefas_grafico2.php';
      break;

    case "tarefas/grafico3":
      include 'tarefas_grafico3.php';
      break;

    case "tarefas/grafico4":
      include 'tarefas_grafico4.php';
      break;

    case "contratotipos":
      include 'contratotipos.php';
      break;

    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}

if ($metodo == "PUT") {

  if ($funcao == "comentario" && $parametro == "cliente") {
    $funcao = "comentario/cliente";
    $parametro = null;
  }
  if ($funcao == "comentario" && $parametro == "atendente") {
    $funcao = "comentario/atendente";
    $parametro = null;
  }
  if ($funcao == "demanda" && $parametro == "validar") {
    $funcao = "demanda/validar";
    $parametro = null;
  }
  if ($funcao == "demanda" && $parametro == "retornar") {
    $funcao = "demanda/retornar";
    $parametro = null;
  }

  if ($funcao == "tarefas" && $parametro == "iniciar") {
    $funcao = "tarefas/iniciar";
    $parametro = null;
  }

  switch ($funcao) {
    case "contratostatus":
      include 'contratostatus_inserir.php';
      break;

    case "tipostatus":
      include 'tipostatus_inserir.php';
      break;

    case "tipoocorrencia":
      include 'tipoocorrencia_inserir.php';
      break;

    case "demanda":
      include 'demanda_inserir.php';
      break;

    case "tarefas":
      include 'tarefas_inserir.php';
      break;

    case "contrato":
      include 'contrato_inserir.php';
      break;

    case "previsao":
      include 'previsao_inserir.php';
      break;

    case "comentario/cliente":
      include 'comentario_cliente_inserir.php';
      break;

    case "comentario/atendente":
      include 'comentario_atendente_inserir.php';
      break;

    case "demanda/validar":
      include 'demanda_validar.php';
      break;

    case "demanda/retornar":
      include 'demanda_retornar.php';
      break;

    case "tarefas/iniciar":
      include 'tarefas_iniciar.php';
      break;

    case "contratotipos":
      include 'contratotipos_inserir.php';
      break;
    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}

if ($metodo == "POST") {

  if ($funcao == "contrato" && $parametro == "finalizar") {
    $funcao = "contrato/finalizar";
    $parametro = null;
  }

  if ($funcao == "demanda" && $parametro == "realizado") {
    $funcao = "demanda/realizado";
    $parametro = null;
  }

  if ($funcao == "tarefas" && $parametro == "stop") {
    $funcao = "tarefas/stop";
    $parametro = null;
  }

  if ($funcao == "tarefas" && $parametro == "realizado") {
    $funcao = "tarefas/realizado";
    $parametro = null;
  }

  if ($funcao == "tarefas" && $parametro == "start") {
    $funcao = "tarefas/start";
    $parametro = null;
  }



  switch ($funcao) {
    case "contratostatus":
      include 'contratostatus_alterar.php';
      break;

    case "tipostatus":
      include 'tipostatus_alterar.php';
      break;

    case "tipoocorrencia":
      include 'tipoocorrencia_alterar.php';
      break;

    case "demanda":
      include 'demanda_alterar.php';
      break;

    case "demanda/realizado":
      include 'demanda_atualizar.php';
      break;

    case "contrato":
      include 'contrato_alterar.php';
      break;

    case "contrato/finalizar":
      include 'contrato_finalizar.php';
      break;

    case "tarefas":
      include 'tarefas_alterar.php';
      break;

    case "usuario/ativar":
      include 'usuario_ativar.php';
      break;

    case "tarefas/stop":
      include 'tarefas_stop.php';
      break;

    case "tarefas/realizado":
      include 'tarefas_realizado.php';
      break;

    case "tarefas/start":
      include 'tarefas_start.php';
      break;

    case "previsao":
      include 'previsao_alterar.php';
      break;

    case "contratotipos":
      include 'contratotipos_alterar.php';
      break;
    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}

if ($metodo == "DELETE") {
  switch ($funcao) {
    case "contratostatus":
      include 'contratostatus_excluir.php';
      break;

    case "tipostatus":
      include 'tipostatus_excluir.php';
      break;
    case "tipoocorrencia":
      include 'tipoocorrencia_excluir.php';
      break;

    case "contrato":
      include 'contrato_excluir.php';
      break;

    case "contratotipos":
      include 'contratotipos_excluir.php';
      break;

    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}