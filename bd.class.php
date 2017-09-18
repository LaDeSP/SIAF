<?php

class bd{

	//host
	private $host = 'localhost';

	//usuario
	private $usuario = 'root';

	//senha
	private $senha = '123456';

	//banco de dados
	private $bd = 'tcc';

	public function conecta_mysql(){

		//cria conexao
		$con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->bd);

		//ajusta charset de comunicação entre aplicação e bd
		mysqli_set_charset($con, 'utf8');

		//verificar se houve erro de conexão
		if(mysqli_connect_errno()){
			echo 'Erro ao tentar se conectar com o BD MySQL: ' .mysqli_connect_error();
		}

		return $con; 
	}
}

?>