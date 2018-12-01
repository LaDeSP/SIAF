<?php

	session_start();

	$msg = isset($_GET['msg']) ? $_GET['msg'] : 0;

	if(!isset($_SESSION['email'])){
		header('Location: index.php');
	}

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<?php
			require_once("head.php");
		?>
		<title>Início</title>
		<link rel="icon" href="imagens/favicon.png">

	</head>

	<body class="branco">
		<?php
			require_once("menu.php");
		?>

		<div style="position: absolute;">
			<?php
			/*		if($msg != 0){
						echo "
							<META HTTP-EQUIV=REFRESH CONTENT = '2;URL=home.php'>
							<script type=\"text/javascript\">
							  alert(\"Logado com Sucesso!\");
							</script>
							";
					}
			*/		
			?>
		</div>
		
			<?php
				require_once("slider.php");
			?>
	    <!--<div class="container espaco">

		    <div class="capa">

		    	<div class="texto-capa">
		    		

			    </div>
		    </div>

				

		</div> -->
	    </div>

		<script src="bootstrap/js/bootstrap.min.js"></script>

	</body>
</html>
