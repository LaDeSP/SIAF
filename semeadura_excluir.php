<?php
	
	require_once('bd.class.php');

	$cod = intval($_GET['inves']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$sql = "DELETE FROM semeadura WHERE idsemeadura = '".$cod ."' ;";

	$resultado = mysqli_query($link, $sql);

	if($resultado){
		echo "
		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=semeadura.php?type=success&text=semeadura excluída com sucesso!&title=Sucesso '>";
	}
	else{
		echo "
		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=semeadura.php?type=error&text=Não foi possível excluir a semeadura!&title=Erro '>";
	}
?>