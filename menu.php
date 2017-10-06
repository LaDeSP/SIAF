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
