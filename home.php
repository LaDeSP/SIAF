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
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="estilos.css" rel="stylesheet">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <!--<img src="imagens/logo.png" />-->
	          <a href="home.php" class="navbar-brand">
	          <span class="img-logo">Logo</span>
	          </a>
	        </div>

	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	          	<li><a href="home.php">Início</a></li>
	            <li><a href="despesas.php">Despesas</a></li>
	            <li><a href="investimentos.php">Investimentos</a></li>
	            <li><a href="vendas.php">Vendas</a></li>
	            <li><a href="estoque.php">Estoque</a></li>
	            <li><a href="produtos.php">Produtos</a></li>
	           	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>
	            	Relatórios <b class="caret"></b></a>
					  <ul class="dropdown-menu">
					    <li><a href="#">Relatório de Despesas</a></li>
					    <li><a href="#">Relatório de Investimentos</a></li>
					    <li><a href="relatorio_vendas.php">Relatório de Vendas</a></li>
					    <li><a href="#">Relatório de Perda de Produtos</a></li>
					    <li><a href="#">Margens</a></li>
					  </ul>
	            </li>
	            <li class="divisor" role="separator"></li>

	            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>
	            	Usuário <b class="caret"></b></a>
					  <ul class="dropdown-menu">
					    <li><a href="exibir_cadastro.php">Meu Cadastro</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="sair.php">Sair</a></li>
					  </ul>
	            </li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container espaco">
		    <div class="capa">
		    	<div class="texto-capa">
			    </div>
		    </div>

		    <section id="sliderhome slid">
		    	<div id="meuSlider" class="carousel slide" data-ride="carousel">
		    	<ol class="carousel-indicators">
		    		<li data-target="#meuSlider" data-slide-to="0" class="active"></li>
		    		<li data-target="#meuSlider" data-slide-to="1" class=""></li>
		    	</ol>
		    		<div class="carousel-inner">
		    			<div class="item active"><img src="imagens/slide1.png" alt="Slide 1"></div>
		    			<div class="item"><img src="imagens/slide2.png" alt="Slide 2"></div>
		    		</div>

		    		<a class="left carousel-control" href="#meuSlider" data-slide="prev">
		    			<span class="glyphicon glyphicon-chevron-left"></span>
		    		</a>
		    		<a class="right carousel-control" href="#meuSlider" data-slide="next">
		    			<span class="glyphicon glyphicon-chevron-right"></span>
		    		</a>

		    	</div>
		    </section>
		</div>


	    </div>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	</body>
</html>
