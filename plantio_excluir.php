<?php
	
	require_once('bd.class.php');

	$cod = intval($_GET['inves']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$sql = " DELETE FROM plantio WHERE idplantio = '$cod' ";

	$resultado = mysqli_query($link, $sql);

	if($resultado){
		echo "
		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=plantio.php?type=success&text=plantio excluído com sucesso!&title=Sucesso '>";
	}
	else{
		echo "
		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=plantio.php?type=error&text=Não foi possível excluir o plantio!&title=Erro '>";
	}
?>