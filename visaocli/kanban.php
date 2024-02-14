<?php 

function montaKanban($kanbanDemanda)
{
	$dataAtual = date("d/m/Y"); 
    $hr = '';
    $dataNaTela = '';
    $atendenteNaTela = '';

    $dataFechamento = null;
    if(isset($kanbanDemanda['dataFechamentoFormatada'])){
        $dataFechamento = $kanbanDemanda['dataFechamentoFormatada'];
    }

    $dataPrevisaoInicio = null;
    if(isset($kanbanDemanda['dataPrevisaoInicio'])){
        $dataPrevisaoInicio = $kanbanDemanda['dataPrevisaoInicioFormatada']; 
    }
    
    if (isset($kanbanDemanda['idAtendente'])) {
        $hr = '<hr class="mt-2 mb-0">';
        $atendenteNaTela = '<span class="ts-cardDataPrevisao">' . ' ' . $kanbanDemanda['nomeAtendente'] . '</span>';
    }

    if ($kanbanDemanda['idTipoStatus'] == TIPOSTATUS_REALIZADO || $kanbanDemanda['idTipoStatus'] == TIPOSTATUS_VALIDADO) {
        if($dataFechamento != null){
            $hr = '<hr class="mt-2 mb-0">';
            $dataNaTela= '<span class="ts-cardDataPrevisao">' . ' Entrega: ' . $dataFechamento . '</span>';
        }
    } else {
        if ($dataPrevisaoInicio != null) {
            $hr = '<hr class="mt-2 mb-0">';
            $dataNaTela= '<span class="ts-cardDataPrevisao">' . ' Previsão: ' . $dataPrevisaoInicio . '</span>';
        }
    
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
			$kanbanDemanda["idDemanda"] . ' ' . $kanbanDemanda["tituloDemanda"] . 
            $hr . $atendenteNaTela . '<br>' . $dataNaTela . 
		'</span>';
		
	return $kanban;
}

?>