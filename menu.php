<?php
  require_once('bd.class.php');

  if(!isset($_SESSION['email'])){
    header('Location: index.php');
  }

  $erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;

  $email = $_SESSION['email'];

  $sql = " SELECT  nome_proprietario, email, telefone, nome_propriedade, localizacao, nome_municipio, estados.id, nome_estado FROM proprietarios, municipios, estados WHERE email = '$email' AND municipios_id = municipios.id AND estados_id = estados.id ";

  $objBd = new bd();
  $link = $objBd->conecta_mysql();

  $resultado = mysqli_query($link, $sql);

  if($resultado){
    $dados_usuario = array();
    
    while($linha = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
      $dados_usuario[] = $linha; 
    }
  }
  else{
    echo 'Erro na execução da consulta, favor entrar em contato com o administrador do site';
  }

?>

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
            Plantio Mensal <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="plantiomensal.php"> Tabela Plantio Mensal </a></li>
              <li class="divider"></li>
              <li><a href="semeadura.php"> Semeadura </a></li>
              <li><a href="plantio.php"> Plantio</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>
            Relatórios <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="relatorio_despesas.php">Relatório de Despesas</a></li>
              <li><a href="relatorio_investimentos.php">Relatório de Investimentos</a></li>
              <li><a href="relatorio_vendas.php">Relatório de Vendas</a></li>
              <li><a href="relatorio_perdas.php">Relatório de Perda de Produtos</a></li>
              <li><a href="relatorio_margens.php">Margens</a></li>
            </ul>
          </li>
          <li class="divisor" role="separator"></li>

          <li class="dropdown" ><a  href="#" class="dropdown-toggle" data-toggle="dropdown">
            <text>Conectado como  <br>
                <?php foreach($dados_usuario as $usuario){ ?>
                    <?php echo $usuario['nome_proprietario']; ?>
                <?php } ?>
            </text>
            <b class="caret"></b></a> <img class="img-responsive" src="imagens/agr.png" style="width: 20%; margin-left: 55%; margin-top: -25%; display: block;">
        
        
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
<br><br><br>
 