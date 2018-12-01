<?php

	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>SIAF - Sistema de Informação para a Agricultura Familiar</title>
		<link rel="icon" href="imagens/favicon.png">

		<?php include 'head.php' ?>

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

	</head>

	<body>

		
	       <center> <img src="imagens/logomarca.png" class="img-responsive lgindex"> <br> <br>
	       			<img class="img-responsive" style="margin-top: 0%" src="imagens/letra.png" class="lgindex2">

	       		<h3 style="margin-top: 1%; font-weight: 600; font-size: 3vh !important;">Sistema de Informação para a Agricultura Familiar</h3>
	       </center>
	        <a href="index.php" class="navbar-brand"><img style="visibility: hidden;"  src="imagens/logomarca.png" align="left" height="100%"> </a><a href="index.php" class="navbar-brand"><img style="visibility: hidden;"  src="imagens/logomarca.png" align="left" height="100%"> </a>
	        <a href="index.php" class="navbar-brand"><img style="visibility: hidden;"  src="imagens/logomarca.png" align="left" height="100%"> </a>
	        <a href="index.php" class="navbar-brand"><img style="visibility: hidden;"  src="imagens/logomarca.png" align="left" height="100%"> </a>
	        <a href="index.php" class="navbar-brand"><img style="visibility: hidden;"  src="imagens/logomarca.png" align="left" height="100%"> </a>
	        <a href="index.php" class="navbar-brand"><img style="visibility: hidden;"  src="imagens/logomarca.png" align="left" height="100%"> </a>
	        <a href="index.php" class="navbar-brand"><img style="visibility: hidden;"  src="imagens/logomarca.png" align="left" height="100%"> </a>
	        <a href="index.php" class="navbar-brand"><img style="visibility: hidden;"  src="imagens/logomarca.png" align="left" height="100%"> </a>
	        <a href="index.php" class="navbar-brand"><img style="visibility: hidden;"  src="imagens/logomarca.png" align="left" height="100%"> </a>

				<div class="col-md-3 cont">
					<br /><br />
	                <div class="form-bottom">
				        <form method="post" action="validar_login.php" id="formLogin">
							<div class="form-group">
							<input type="text" class="form-control" id="campo_usuario" name="email" placeholder="E-mail" required>
							</div>

							<div class="form-group">
								<input type="password" class="form-control red" id="campo_senha" name="senha" placeholder="Senha" required>
							</div>
							<center>
								<button  type="button" class="btn1" id="btn_login">Entrar</button>
							</center> <br /> 
							<font size="3%">
								<a  href=""> Esqueceu sua senha? </a> <br>
								<a style="color: black; font-weight: 800" href="form_cadastro_usuario.php">  Cadastre-se</a>	
								<br /> <br />
								<?php
									if($erro == 1){
										echo '<p class="alert-danger">Email ou senha incorretos!</p>';
										echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=index.php'>";
								}
				?>
							</font>
						</form>
			        </div>
	            </div>
				

	   

	</body>
	
		<div class="row" >
			<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white" id="rodape">
				<span style="color: white">© SIAF - Sistema de Informação para a Agricultura Familiar | Todos os direitos reservados.</span><br />
	    		<span style="color: white">Desenvolvido por Paulo Abreu.</span>
			</div>
		</div>	

</html>
