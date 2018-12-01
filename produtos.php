<?php

	require_once('bd.class.php');
	session_start();

	if(!isset($_SESSION['email'])){
		header('Location: index.php');
	}

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$email = $_SESSION['email'];
	$select = "select email from proprietarios where email = '$email'";

	$result = mysqli_query($link, $select);

	if($result){
		$user_id = array();

		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$user_id = $row;
	}

	$email = $user_id['email'];

	$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

	$sql = " SELECT * FROM produtos WHERE proprietarios_email = $email ORDER BY nome_produto ASC ";

	$resultado = mysqli_query($link, $sql);

	$total_produtos = mysqli_num_rows($resultado);
	$quantidade_pg = 10;
	$num_pg = ceil($total_produtos/$quantidade_pg);
	$inicio = ($quantidade_pg*$pagina)-$quantidade_pg;

	$result_produtos = " SELECT * FROM produtos WHERE proprietarios_email = $email ORDER BY nome_produto ASC LIMIT $inicio, $quantidade_pg  ";
	$resultado_produtos = mysqli_query($link, $result_produtos);
	$total_produtos = mysqli_num_rows($resultado_produtos);
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<?php require_once("head.php")  ?>
		<title>Produtos</title>
	</head>

	<body class="branco">

		<?php
		require_once("menu.php");
		?>


	    <div class="container">
	    	<div class="page-header espaco">
	    		<h1>Produtos</h1>
	    	</div>

	    	<div class="pull-right">
	    		<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModalcad">
	    		Registrar
	    		</button>

			<div class="modal fade" id="myModalcad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Registrar - Produto</h4>
						</div>
						<div class="modal-body">

							<form method="POST" action="produtos.php" enctype="multipart/form-data" id="formEditarCad">

								<div class="form-group">
									<label for="nome" class="control-label">Nome *</label>
									<input type="text" pattern="[A-Za-zÀ-ú0-9., -]{5,}$"" class="form-control" id="nome" name="nome" placeholder="Ex: Mandioca" required>
								</div>
								

								<div class="form-group">
									<label for="unidade" class="control-label">Unidade *</label><br />
									<select name="unidade" id="unidade" required>
										<option value="">Selecione...</option>
										<option value="KG">KG</option>
										<option value="LT">LT</option>
										<option  value="UN">UN</option>
										<option value="DZ">DZ</option>
									</select>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-success" name="salvar">Registar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

	    	</div>
	    	<br />


			<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>Produto</th>
						<th>Unidade</th>
						<th>Ações</th>
					</tr>
				</thead>

				<tbody>
				<?php while($produtos = mysqli_fetch_assoc($resultado_produtos)){ ?>
					<tr class="linha">
						<td><?php echo $produtos['nome_produto']; ?></td>
						<td><?php echo $produtos['unidade']; ?></td>
						<td>
						<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal" data-codproduto="<?php echo $produtos['id']; ?>" data-nome="<?php echo $produtos['nome_produto']; ?>"
						data-unidade="<?php echo $produtos['unidade']; ?>" data-destino="<?php echo $produtos['destino']; ?>">
						Editar
						</button>
						<a  href="javascript:m(); function m(){ modal({
	                      	type: 'confirm',
		                      	title: 'Confimação',
		                      	text: 'Tem certeza que deseja excluir este produto?',
		                      	buttonText: {
	                        	yes: 'Confirmar',
	                        	cancel: 'Cancelar'
		                      	},
		                      	callback: function(result) {
		                        	$('.modal-btn').attr('style', 'display: none !important');
		                        	if(result==true){
		                        	location.href='produtos_excluir.php?prod=<?php echo $produtos['id']?>'
		                      	}

		                    	}
                    		}); $('.modal-btn').attr('style', 'display: inline !important'); };" class="btn btn-xs btn-danger"">Excluir</a>

						</td>
					</tr>
				<?php } ?>
				</tbody>

			</table>


			<div class="clearfix"></div>
			<div class="col-md-4"></div>

			<div class="col-md-4">

				<?php
					$pagina_anterior = $pagina - 1;
					$pagina_posterior = $pagina + 1;
				?>
				<nav aria-label="Page navigation">
				  <ul class="pagination">
				    <li>
				    <?php
				    	if($pagina_anterior != 0){ ?>
					      <a href="produtos.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
					        <span aria-hidden="true">&laquo;</span>
					      </a>
					<?php }else{ ?>
							<span aria-hidden="true">&laquo;</span>
				    <?php } ?>
				    </li>

				    <?php
				    	for($i = 1;  $i < $num_pg + 1; $i++){ ?>
				    		<li><a href="produtos.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				    <?php } ?>

				    <li>
				    <?php
				    	if($pagina_posterior <= $num_pg){ ?>
					      <a href="produtos.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
					        <span aria-hidden="true">&raquo;</span>
					      </a>
					<?php }else{ ?>
							<span aria-hidden="true">&raquo;</span>
				    <?php } ?>
				    </li>

				  </ul>
				</nav>
			</div>

			<div class="col-md-4"></div>

		</div>
	    </div>

		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="exampleModalLabel">Editar</h4>
		      </div>
		      <div class="modal-body">
		        <form method="POST" action="produtos.php" id="formEditarCad">
		          <div class="form-group">
		            <label for="produto-name" class="control-label">Nome *</label>
		            <input name="nome" type="text" class="form-control" id="produto-name" required="requiored">
		         </div>
		         <div class="form-group">
					<label for="destino-name" class="control-label">Destino *</label>
					<input name="destino" type="text" class="form-control" id="destino-name" required="requiored">
				</div>
				  <div class="form-group">
					<label for="unidade-name" class="control-label">Unidade *</label><br />
					<select name="unidade" id="unidade-name" required="requiored">
						<option>Selecione...</option>
						<option value="KG">KG</option>
						<option value="LT">LT</option>
						<option  value="UN">UN</option>
						<option value="DZ">DZ</option>
					</select>
				   </div>
		          </div>
		          <input name="id" type="hidden" id="cod-produto">
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			        <button name="editar" type="submit" class="btn btn-success">Alterar</button>
			      </div>
		        </form>
		      </div>	
		    </div>
		  </div>
		</div>

		<script src="bootstrap/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			$('#exampleModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var recipientnome = button.data('nome') // Extract info from data-* attributes
				var recipientcod = button.data('codproduto')
				var recipientunidade = button.data('unidade')
			  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
			 	modal.find('.modal-title').text('Editar - ' + recipientnome)
			 	modal.find('#cod-produto').val(recipientcod)
			 	modal.find('#produto-name').val(recipientnome)
			 	modal.find('#unidade-name').val(recipientunidade)
			})
		</script>

		<?php
			function registraProduto(){
				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$nome =$_POST['nome'];
				$unidade = $_POST['unidade'];
				$email = $_SESSION['email'];

				$select = "select email from proprietarios where email = '$email'";
				$resultado = mysqli_query($link, $select);

				if($resultado){
					$user_id = array();

					$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
					$user_id = $row;
				}

				$email = $user_id['email'];

				$sql = " CALL produtos('$nome', '$unidade', '$email')";

				//executar a query
				$result=mysqli_query($link, $sql);
				
				if(mysqli_num_rows($result)){
		            echo "
		            <META HTTP-EQUIV=REFRESH CONTENT = '2;URL=produtos.php'>
		            <script type=\"text/javascript\">
              
		             $(window).load(function() {
		                 modal({
		                 type: 'success',
		                 title: 'Sucesso',
		                 text: 'Produto registrado!',
		                 autoclose: false,
		                 size: 'large',
		                 center: false,
		                 theme: 'atlant',
		                });
		              });
		            </script>
		            ";
				}
				else{
					echo "
		            <META HTTP-EQUIV=REFRESH CONTENT = '2;URL=produtos.php'>
		            <script type=\"text/javascript\">
		              $(window).load(function() {
		                 modal({
		                 type: 'error',
		                 title: 'Erro',
		                 text: 'Não foi possível registrar o produto!',
		                 autoclose: false,
		                 size: 'large',
		                 center: false,
		                 theme: 'atlant',
		                });
		              });
		            </script>
		            ";
				}
			}

			if(isset($_POST['salvar'])){
					registraProduto();
			}

			function editarProduto(){
				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$cod = $_POST['id'];
				$nome = $_POST['nome'];
				$unidade = $_POST['unidade'];

				$sql = "CALL produtos_edt('$nome', '$unidade', '$id')";

				$resultado = mysqli_query($link, $sql);

				if(mysqli_affected_rows($link) != 0){
						echo "
							<META HTTP-EQUIV=REFRESH CONTENT = '2;URL=produtos.php'>
							<script type=\"text/javascript\">

				             $(window).load(function() {
				                 modal({
				                 type: 'success',
				                 title: 'Sucesso',
				                 text: 'Produto alterado com sucesso!',
				                 autoclose: false,
				                 size: 'large',
				                 center: false,
				                 theme: 'atlant',
				                });
				              });

				        
				            </script>
							";
						}else{
						echo "
							<META HTTP-EQUI=REFRESH CONTENT = '2;URL=produtos.php'>
							<script type=\"text/javascript\">
				              $(window).load(function() {
				                 modal({
				                 type: 'error',
				                 title: 'Error',
				                 text: 'Produto não pode ser alterado!',
				                 autoclose: true,
				                 size: 'large',
				                 center: false,
				                 theme: 'atlant',
				                });
				              });
				            </script>
						";
					}
			}

			if(isset($_POST['editar'])){
				editarProduto();
			}
		?>

	</body>
</html>
