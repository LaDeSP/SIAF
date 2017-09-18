<?php

	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>SIAF - Sistema de Informação para a Agricultura Familiar</title>
		<link rel="icon" href="imagens/favicon.png">

		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="estilos.css" rel="stylesheet">

		<script>
			$(document).ready( function(){

				$('#btn_login').click(function(){

					var campo_vazio = false;

					if($('#campo_usuario').val() == ''){
						$('#campo_usuario').css({'border-color': '#FF0000'});
						campo_vazio = true; 
					}else{
						$('#campo_usuario').css({'border-color': '#CCC'});
					}

					if($('#campo_senha').val() == ''){
						$('#campo_senha').css({'border-color': '#FF0000'});
						campo_vazio = true; 
					}else{
						$('#campo_senha').css({'border-color': '#CCC'});
					}

					if(campo_vazio) return false;
				});
			});

		</script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <!--<img src="imagens/logo.png" />-->
	          <a href="index.php" class="navbar-brand">
	          <span class="img-logo">SIAF</span>
	          </a>
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="form_cadastro_usuario.php">Cadastre-se</a></li>
	            <li class="<?= $erro == 1 ? 'open' : '' ?>">
	            	<a id="entrar" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entrar</a>
					<ul class="dropdown-menu" aria-labelledby="entrar">
						<div class="col-md-12">
				    		<p>Já possui cadastro?</h3>
				    		<br />

							<form method="post" action="validar_login.php" id="formLogin">
								<div class="form-group">
									<input type="text" class="form-control" id="campo_usuario" name="email" placeholder="E-mail" required="requiored">
								</div>
								
								<div class="form-group">
									<input type="password" class="form-control red" id="campo_senha" name="senha" placeholder="Senha" required="requiored">
								</div>
								
								<button type="buttom" class="btn btn-primary" id="btn_login">Entrar</button>

								<br /><br />
							</form>

							<?php

							if($erro == 1){
								echo '<font color="#FF0000">E-mail ou senha incorretos </font>';
							}

							?>

						</form>
				  	</ul>
	            </li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>

	    <div class="container">
		    <div class="capa">
		    	<div class="texto-capa">
			    </div>
		    </div>

		    <section id="sliderhome slid" style="padding-bottom: 20px">
		    	<div id="meuSlider" class="carousel slide" data-ride="carousel">
		    	<ol class="carousel-indicators">
		    		<li data-target="#meuSlider" data-slide-to="0" class="active"></li>
		    		<li data-target="#meuSlider" data-slide-to="1" class=""></li>
		    		<li data-target="#meuSlider" data-slide-to="2" class=""></li>
		    	</ol>
		    		<div class="carousel-inner">
		    			<div class="item active"><img src="imagens/slide1.png" alt="Slide 1"></div>
		    			<div class="item"><img src="imagens/slide2.png" alt="Slide 2"></div>
		    			<div class="item"><img src="imagens/slide3.png" alt="Slide 3"></div>
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

	    <section id="servicos">
	    	<div class="container">

	    		<div class="row">
	    			<div class="col-md-6 foto">
	    				<img src="imagens/01.png" class="img-responsive">
	    			</div>

	    			<div class="col-md-6">
	    				<h2>O que o SIAF faz?</h2>

	    				<h3>Registra suas Despesas e Investimentos</h3>
	    				<p>Quer ter melhor controle das despesas e investimentos da sua propriedade? Registre aqui e visualize de maneira prática e fácil como andam os seus gastos.</p>

	    				<h3>Registra seus Produtos, Estoque e Vendas</h3>
	    				<p>Produz? Registre os produtos que produz em sua propriedade. Produziu? Registre os produtos produzidos no estoque. Vendeu? Registre suas vendas. Assim, você poderá acompanhar com andam os seus rendimentos.</p>

	    				<h3>Gera Relatórios</h3>
	    				<p>Visualize seus resultados periódicos de maneira rápida através de relatórios que são gerados apenas com um clique.</p>
	    			</div>
	    		</div>

	    	</div>
	    </section>

	    <section id="recursos">
	    	<div class="container">
	    		<div class="row">
	    			
	    			<div class="col-md-6">
	    				<h2>Fácil de Usar!</h2>

	    				<h3>Simples</h3>
	    				<p>O SIAF possui interface simples e de fácil entendimento para que possa atender com mais eficiência os seus usuários.</p>

	    				<h3>Útil</h3>
	    				<p>O SIAF dá apoio à atividades administrativas e financeiras de uma propriedade rural agregando benefícios, como, melhoria na organização e controle, redução de custos e riscos, além de potencializar a competitividade.</p>

	    				<h3>Acessível</h3>
	    				<p>O SIAF foi desenvolvido para se adequar a qualquer dispositivo com acesso à internet seja ele um computador, um tablet ou um celular.</p>
	    			</div>

	    			<div class="col-md-6 foto">
	    				<img src="imagens/02.png" class="img-responsive">
	    			</div>

	    		</div>
	    	</div>
	    </section>

	    <footer id="rodape">
	    	<div class="container">
	    		<div class="row">
	    			<span style="color: white">© SIAF - Sistema de Informação para a Agricultura Familiar | Todos os direitos reservados.</span><br />
	    			<span style="color: white">Desenvolvido por Paulo Abreu.</span>
	    		</div>
	    	</div>
	    </footer>

	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>