<?php

	require_once('bd.class.php');
	require_once('funcoes.php');
	session_start();

	if(!isset($_SESSION['email'])){
		header('Location: index.php');
	}

  	$objBd = new bd();
  	$link = $objBd->conecta_mysql();

  	$email = $_SESSION['email'];
  	$select = "select email from proprietarios where email = '". $email ."';";

  	$result = mysqli_query($link, $select);

  	if($result){
    	$user_id = array();

   	 	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    	$user_id = $row;
  	}

  	$email = $user_id['email'];

  	$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

  	$sql = "SELECT idplantiomensal, cultura, variedade, observacao FROM plantiomensal WHERE proprietarios_email = '". $email ."' ORDER BY idplantiomensal;";

  	$resultado = mysqli_query($link, $sql);

   	$total_plantiomensal= mysqli_num_rows($resultado);
  	$quantidade_pg = 10;
  	$num_pg = ceil($total_plantiomensal/$quantidade_pg);
  	$inicio = ($quantidade_pg*$pagina)-$quantidade_pg;

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<?php require_once("head.php")  ?>
		<title>Plantio Mensal</title>
	</head>

	<body class="branco">

		<?php
		require_once("menu.php");
		?>

	    <div class="container">
	    	<div class="page-header espaco">
	    		<h1>Plantio Mensal</h1>
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
							<h4 class="modal-title" id="myModalLabel">Registrar - Plantio Mensal</h4>
						</div>
						<div class="modal-body">

							<form method="POST" action="plantiomensal.php" enctype="multipart/form-data">


								<div class="form-group">
									<label for="cultura" class="control-label">Cultura *</label>
									<input type="text" class="form-control" pattern="[A-Za-zÀ-ú0-9., -]{3,}$" id="cultura" name="cultura" placeholder="Ex: grãos,  vegetais, algas, árvores" required>
								</div>

					            <div class="form-group">
					            	<label for="variedade" class="control-label">Variedade *</label>
					           	    <textarea class="form-control" id="variedade" pattern="[A-Za-zÀ-ú0-9., -]{5,}$" name="variedade" placeholder="" required=""></textarea>
					            </div>

					            <div class="form-group">
					            	<label for="observacao" class="control-label">Observação</label>
					           	    <textarea class="form-control" id="observacao" pattern="[A-Za-zÀ-ú0-9., -]{5,}$" name="observacao" placeholder=""></textarea>
					            </div>

								<br />

								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-success" name="salvar">Registrar</button>
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
						<th>Cultura</th>
						<th>Variedade</th>
						<th>Observação</th>
					</tr>
				</thead>

				<tbody>
				<?php while($plantio = mysqli_fetch_assoc($resultado)){ ?>
					<tr class="linha">
						<td><?php echo $plantio['cultura']; ?></td>
						<td><?php echo $plantio['variedade']; ?></td>
						<td><?php echo $plantio['observacao']; ?></td>
						<td>
						<!---<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal"
								data-codinvestimento="<?php echo $investimento['id']; ?>"
								data-nome="<?php echo $investimento['nome_investimento']; ?>"
								data-descricao="<?php echo $investimento['descricao']; ?>"
								data-valor="<?php echo formata_moeda($investimento['valor']); ?>"
								data-data="<?php echo date("d/m/Y", strtotime($investimento['data'])); ?>">
								Editar
						</button> ---->
						<a  href="javascript:m(); function m(){ modal({
	                      	type: 'confirm',
		                      	title: 'Confimação',
		                      	text: 'Tem certeza que deseja excluir este Plantio ?',
		                      	buttonText: {
	                        	yes: 'Confirmar',
	                        	cancel: 'Cancelar'
		                      	},
		                      	callback: function(result) {
		                        	$('.modal-btn').attr('style', 'display: none !important');
		                        	if(result==true){
		                        	location.href='plantiomensal_excluir.php?inves=<?php echo $plantio['idplantiomensal']?>'
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
		                <a href="plantiomensal.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
		                  <span aria-hidden="true">&laquo;</span>
		                </a>
		          <?php }else{ ?>
		              <span aria-hidden="true">&laquo;</span>
		            <?php } ?>
		            </li>

		            <?php
		              for($i = 1;  $i < $num_pg + 1; $i++){ ?>
		                <li><a href="plantiomensal.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
		            <?php } ?>

		            <li>
		            <?php
		              if($pagina_posterior <= $num_pg){ ?>
		                <a href="plantiomensal.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
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



		<!---<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="exampleModalLabel">Editar</h4>
		      </div>
		      <div class="modal-body">
		        <form method="POST" action="investimentos.php">
		          <div class="form-group">
		            <label for="produto-name" class="control-label">Nome *</label>
		            <input name="nome" type="text" class="form-control" pattern="[A-Za-zÀ-ú0-9., -]{5,}$" id="investimento-name" required="requiored">
		          </div>
		          <div class="form-group">
		            <label for="descricao-name" class="control-label">Descrição </label>
		            <textarea name="descricao" type="text" class="form-control" id="descricao-name"></textarea>
		          </div>

		          <div class="row">
				  <div class="form-group col-md-8">
				  	<label for="valor-name" class="control-label">Valor R$ *</label>
					<input name="valor" type="text" class="form-control ValoresItens" data-affixes-stay="true" data-prefix="R$ " data-thousands="." data-decimal="," id="valor-name" name="valor" placeholder="Valor R$" id="valor-name" required="requiored">
				  </div>

				  <div class="form-group col-md-4">
				  	<label for="data-name" class="control-label">Data *</label>
					<input type="date" class="form-control" id="data-name" name="data" required="requiored">
				  </div>

				   </div>

		          <input name="id" type="hidden" id="cod-investimento">

			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			        <button type="submit" class="btn btn-primary" name="editar">Alterar</button>
			      </div>
		        </form>
		      </div>
		    </div>
		  </div>
		</div> --->

		<script src="bootstrap/js/bootstrap.min.js"></script>

		<!---<script type="text/javascript">
			$('#exampleModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var recipientcultura = button.data('cultura') // Extract info from data-* attributes
				var recipientcod = button.data('codplantio')
				var recipientobservacao = button.data('observacao')
				var recipientvariedade = button.data('variedade')

			  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
			 	modal.find('.modal-title').text('Editar - Investimento #' + recipientcod)
			 	modal.find('#cod-investimento').val(recipientcod)
			 	modal.find('#investimento-name').val(recipientnome)
			 	modal.find('#descricao-name').val(recipientdescricao)
			 	modal.find('#valor-name').val(recipientvalor)
			 	modal.find('#data-name').val(recipientdata)
			})
		</script> --->

		<?php
			function registraPlantio(){
				$cultura = $_POST['cultura'];
				$variedade = $_POST['variedade'];
				$observacao = $_POST['observacao'];

			    $objBd = new bd();
				$link = $objBd->conecta_mysql();

		        $email = $_SESSION['email'];
		        $select = "select email from proprietarios where email = '". $email. "';";
		        $resultado = mysqli_query($link, $select);

		        if($resultado){
		        	$user_id = array();

		            $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		            $user_id = $row;
		        }

		        $email = $user_id['email'];
				
				$sql = "CALL plantiomensal('".$cultura."', '".$variedade."', '".$observacao."', '".$email."');";

				//executar a query
				mysqli_query($link, $sql);

				if($sql){
					echo "
		            <META HTTP-EQUIV=REFRESH CONTENT = '2;URL=plantiomensal.php'>
		            <script type=\"text/javascript\">
              
		             $(window).load(function() {
		                 modal({
		                 type: 'success',
		                 title: 'Sucesso',
		                 text: 'Plantio registrado!',
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
		            <META HTTP-EQUIV=REFRESH CONTENT = '2;URL=plantiomensal.php'>
		           	<script type=\"text/javascript\">
              		$(window).load(function() {
                		modal({
                 			type: 'error',
                 			title: 'Erro',
                 			text: 'Não foi possível registrar o Plantio!',
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
				registraPlantio();
			}

			/*function editarInvestimento(){
				$cod = $_POST['id'];
				$nome = $_POST['nome'];
				$descricao = $_POST['descricao'];
				$valor = $_POST['valor'];

				$data = str_replace("/", "-", $_POST["data"]);
			    $data1 = date('Y-m-d', strtotime($data));

				$objBd = new bd();
				$link = $objBd->conecta_mysql();
				$valor=moeda_clean($valor);
				$sql = "CALL investimentos_edt('$nome', '$descricao', '$data1','$valor','$cod');";


				$resultado = mysqli_query($link, $sql);

				if(mysql_affected_rows($link) != 0){
					echo "
						<META HTTP-EQUIV=REFRESH CONTENT = '2;URL=investimentos.php'>
						<script type=\"text/javascript\">

			             $(window).load(function() {
			                 modal({
			                 type: 'success',
			                 title: 'Sucesso',
			                 text: 'Investimento alterado com sucesso!',
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
						<META HTTP-EQUI=REFRESH CONTENT = '2;URL=investimentos.php'>
						<script type=\"text/javascript\">
			              $(window).load(function() {
			                 modal({
			                 type: 'error',
			                 title: 'Error',
			                 text: 'Investimento não pode ser alterado!',
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
				editarInvestimento();
			}*/
		?>
	</body>
</html>
