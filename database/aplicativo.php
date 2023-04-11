<?php
//Lucas 05042023 criado

include_once('../conexao.php');

function buscaAplicativos($idAplicativo=null)
{

	$app = array();
	//echo json_encode($aplicativo);
	//return;	
	$apiEntrada = array(
		'idAplicativo' => $idAplicativo,
	);
	
	/* echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	return; */	
	$app = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'GET');
	//echo json_encode($app);
	return $app;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {


		$img = $_FILES['imgAplicativo'];
		
		$pasta = "../img/imgAplicativo/";
		$imgAplicativo = $img['name'];
		$novoNomeImg = uniqid(); //gerar nome aleatorio para ser guardado na pasta 
		$extensao = strtolower(pathinfo($imgAplicativo,PATHINFO_EXTENSION)); //extensao do arquivo

		if($extensao != "" && $extensao != "jpg" && $extensao != "png")
        die("Tipo de aquivo não aceito");

		$pathImg = $pasta . $novoNomeImg . "." . $extensao;
		move_uploaded_file($img["tmp_name"],$pathImg);


		$apiEntrada = array(
			'nomeAplicativo' => $_POST['nomeAplicativo'],
			'imgAplicativo' => $imgAplicativo,
			'pathImg'=> $pathImg,
			
		);
		/*  echo json_encode($_POST);
		echo "\n";
		echo json_encode($apiEntrada);
		return;  */
		$app = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'PUT');
		
	}

    if ($operacao == "alterar") {

		$img = $_FILES['imgAplicativo'];
		
		$pasta = "../img/imgAplicativo/";
		$imgAplicativo = $img['name'];
		$novoNomeImg = uniqid(); //gerar nome aleatorio para ser guardado na pasta 
		$extensao = strtolower(pathinfo($imgAplicativo,PATHINFO_EXTENSION)); //extensao do arquivo

		if($extensao != "" && $extensao != "jpg" && $extensao != "png")
        die("Tipo de aquivo não aceito");

		$pathImg = $pasta . $novoNomeImg . "." . $extensao;
		move_uploaded_file($img["tmp_name"],$pathImg);
		
		$apiEntrada = array(
			'idAplicativo' => $_POST['idAplicativo'],
			'nomeAplicativo' => $_POST['nomeAplicativo'],
			'imgAplicativo' => $_POST['imgAplicativo'],
			'pathImg'=> $pathImg,
		);

		$app = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'POST');
		
	}

	if ($operacao == "excluir") {
		$apiEntrada = array(
			'idAplicativo' => $_POST['idAplicativo']		
		);

		$app = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'DELETE');
		
	}

	
	header('Location: ../sistema/aplicativo.php');
}
