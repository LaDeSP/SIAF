<?php
	
	require_once('bd.class.php');

	$cod = intval($_GET['desp']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$sql = " DELETE FROM despesas WHERE id = '$cod' ";

	$resultado = mysqli_query($link, $sql);

	if($resultado){
		echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=despesas.php'>
            <script type=\"text/javascript\">
              alert(\"Despesa excluída com sucesso!\");
            </script>
            ";
	}
	else{
		echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=despesas.php'>
            <script type=\"text/javascript\">
              alert(\"Não foi possível excluir a despesa!\");
            </script>
            ";
	}
?>