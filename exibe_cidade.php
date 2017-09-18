<?php
	include_once('bd.class.php'); 

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$id = $_GET['id'];

	$result_cidade = " SELECT * FROM municipios WHERE estados_id = $id ORDER BY nome_municipio";
	$resultado_cidade = mysqli_query($link, $result_cidade);
	while($row_cidade = mysqli_fetch_assoc($resultado_cidade)){
		$nome = $row_cidade['nome_municipio'];
		$id = $row_cidade['id'];

		echo '<option value="'.$id.'" class="cidades">'.$nome.'</option>';
	}
?>