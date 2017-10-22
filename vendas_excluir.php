<?php
	require_once('bd.class.php');

	$cod = intval($_GET['venda']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$sql = "CALL vendas_del('$cod'); ";
	
	$resultado = mysqli_query($link, $sql);

	if(mysqli_affected_rows($link)){
		echo "
		    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=vendas.php'>
		    <script type=\"text/javascript\">
		    	alert(\"Venda excluída!\");
		    </script>
		    ";
	}
	else{
		echo "
		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=vendas.php'>
		<script type=\"text/javascript\">
			alert(\"Não foi possível excluir venda!\");
		</script>
		";
	}
?>