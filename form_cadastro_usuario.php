<?php
	require_once('bd.class.php');

	$erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;

	$nome = '';
	$email = '';
	$senha = '';
	$propriedade = '';
	$cidade = '';
	$telefone = '';
	$local = '';

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Sistema</title>
		<link rel="icon" href="imagens/favicon.png">
		
		<!-- jquery - link cdn -->
		<script src="js/JQuery/jquery-2.2.4.min.js"></script>

		<script type="text/javascript" src="bootstrap/js/funcao.js"></script>

		<script src="lib/sweetalert/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="lib/sweetalert/sweetalert.css">

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link href="style.css" rel="stylesheet">
		
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
	            <li><a href="index.php">Voltar</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	    	<div class="col-md-2"></div>

	    	<div class="col-md-7">
	    		<h3 class="page-header espaco">Identificação</h3>

	    		<?php 
	    			include_once('bd.class.php'); 

	    			$objBd = new bd();
					$link = $objBd->conecta_mysql();
	    		?>

	    		<form method="post" action="form_cadastro_usuario.php" id="formCadastrarse">
					<div class="form-group">
		            	<label for="nome" class="control-label">Nome *</label>
						<input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: João" required="requiored">
					</div>

					<div class="form-group">
						<label for="email" class="control-label">E-mail *</label>
						<?php
							if($erro_email){
							echo '<font style="color:#FF0000">Este e-mail já foi cadastrado!</font>';
							}
						?>
						<input type="email" class="form-control" id="email" name="email" placeholder="Ex: joao@seuemail.com" required="requiored">
					</div>
					
					<div class="form-group">
						<label for="senha" class="control-label">Senha *</label>
						<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required="requiored">
					</div>

					<div class="form-group">
						<label for="telefone" class="control-label">Telefone *</label>
						<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Ex: (67) 99309-9373" required="requiored">
					</div>

					<div class="form-group">
						<label for="propriedade" class="control-label">Propriedade *</label>
						<input type="text" class="form-control" id="propriedade" name="propriedade" placeholder="Propriedade" required="requiored">
					</div>

					<div class="form-group">
						<label for="local" class="control-label">Localização</label>
						<input type="text" class="form-control" id="local" name="local" placeholder="Localização">
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label for="id_estado" class="control-label">Estado *</label><br />
							<select name="id_estado" id="id_estado">
								<option value="">Selecione...</option>
								<?php
									$result_estado = "SELECT * FROM estados ORDER BY nome_estado";
									$resultado_estado = mysqli_query($link, $result_estado);
									while($row_estado = mysqli_fetch_assoc($resultado_estado)){
										echo '<option value="'.$row_estado['id'].'">'.$row_estado['nome_estado'].'</option>';
										}
								?>
							</select>
						</div>

						<div class="form-group col-md-6">
							<label for="id_cidade" class="control-label">Cidade *</label><br />
							<select name="id_cidade" id="id_cidade">
								<option value="">Selecione...</option>
							</select> 
						</div>
					</div>
					<br />
					<button type="submit" class="btn btn-primary form-control" name="submit">Cadastrar</button>
	    		</form>
	    	</div>
	    	<div class="col-md-3"></div>

	    	<div class="clearfix"></div>
			<br />
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>

		</div>


	    </div>
	
		<script src="bootstrap/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			$('#id_estado').change(function (){
				var valor = document.getElementById("id_estado").value;

				$.get("cidade.php?search=" + valor, fuction (data) {
					$("#id_cidade").find("option").remove();
					$('#id_cidade').append(data);
				});
			});
		</script>
	
		<?php 
			function registraUsuario(){
				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$nome = $_POST['nome'];
				$email = $_POST['email'];
				$senha = md5($_POST['senha']);
				$propriedade = $_POST['propriedade'];
				$cidade = $_POST['id_cidade'];
				$telefone = $_POST['telefone'];
				$local = $_POST['local'];

				$email_existe = false; 

				//verifica se o email já foi cadastrado 
				$sql = " SELECT * FROM proprietarios WHERE email = '$email' ";

				if($resultado_id = mysqli_query($link, $sql)){

					$dados_usuario = mysqli_fetch_array($resultado_id);

					if(isset($dados_usuario['email'])){
						$email_existe = true;
					}

				}else{
					echo 'Erro ao localizar registro do usuário!';
				}

				if($email_existe){
					$retorno_get = '';

					if($email_existe){
						$retorno_get.= "erro_email=1&";
					}

					header('Location: cadastro_usuario.php?'.$retorno_get);
					die();
				}


				$sql = " INSERT INTO proprietarios(nome_proprietario, telefone, email, senha, nome_propriedade, localizacao, municipios_id) values ('$nome', '$telefone', '$email', '$senha', '$propriedade', '$local', '$cidade') ";

				mysqli_query($link, $sql);

				if($sql){
					echo "
						<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=index.php'>
						<script type=\"text/javascript\">
							alert(\"Cadastro realizado com sucesso! Faça login e aproveite todas as funcionalidades do sistema!\");
						</script>
						";
				}
				else{
					echo "
						<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=index.php'>
						<script type=\"text/javascript\">
							alert(\"Não foi possível realizar o cadastro!\");
						</script>
						";
				}
			}

			if(isset($_POST['submit'])){
					registraUsuario();
			}
		?>
	</body>
</html>