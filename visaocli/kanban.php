<?php 

function montaKanban($kanbanDemanda)
{
	$dataAtual = date("d/m/Y"); 
    $dataNaTela = null;

    $dataFechamento = null;
    if(isset($kanbanDemanda['dataFechamento'])){
        $dataFechamento = date('d/m/Y', strtotime($kanbanDemanda["dataFechamento"]));
    }

    $dataPrevisaoInicio = null;
    if(isset($kanbanDemanda['dataPrevisaoInicio'])){
        $dataPrevisaoInicio = date('d/m/Y', strtotime($kanbanDemanda["dataPrevisaoInicio"])); 
    }

    if($dataFechamento != null){
        $dataNaTela= '<hr class="mt-2 mb-0">' . '<span class="ts-cardDataPrevisao">' . ' Entrega: ' . $dataFechamento . '</span>';
    }
    if(($dataPrevisaoInicio != null) && $dataFechamento == null){
        $dataNaTela= '<hr class="mt-2 mb-0">' . '<span class="ts-cardDataPrevisao">' . ' Previsão: ' . $dataPrevisaoInicio . '</span>';
    }
	
	$kanban = '<span class="card-body border board mt-2 ts-click';
	if(($dataPrevisaoInicio != null) && ($dataPrevisaoInicio <= $dataAtual) && $kanbanDemanda['idTipoStatus'] != TIPOSTATUS_REALIZADO){
		$kanban = $kanban . ' ts-cardAtrasado';
	}
	$kanban = $kanban . '" id="kanbanCard" data-idDemanda="' . $kanbanDemanda["idDemanda"] . '"  >';

		if(isset($kanbanDemanda["idContrato"])){
			$kanban = $kanban .$kanbanDemanda["nomeContrato"] . ' : ' . $kanbanDemanda["idContrato"] . ' ' . $kanbanDemanda["tituloContrato"]. '<br>' ;
		}
		
		$kanban = $kanban .
			$kanbanDemanda["idDemanda"] . ' ' . $kanbanDemanda["tituloDemanda"] . '<br>' .
			' ' . $dataNaTela . 
		'</span>';
		
	return $kanban;
}

?>