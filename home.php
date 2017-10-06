<?php

	session_start();

	if(!isset($_SESSION['email'])){
		header('Location: index.php');
	}

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Início</title>
		<link rel="icon" href="imagens/favicon.png">

		<!-- jquery - link cdn -->
		<script src="js/JQuery/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link href="estilos.css" rel="stylesheet">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>
		<?php
		require_once("menu.php");
		?>



	    <div class="container espaco">
		    <div class="capa">
		    	<div class="texto-capa">
			    </div>
		    </div>

				<?php
				require_once ("slider.php");
				?>

		</div>


	    </div>

		<script src="bootstrap/js/bootstrap.min.js"></script>

	</body>
</html>
