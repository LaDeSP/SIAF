<?php

	session_start();

	require_once('bd.class.php'); 

	$email = $_POST['email'];
	$senha = md5($_POST['senha']);

	$sql = "SELECT * FROM proprietarios WHERE email = '". $email. "' AND senha = '". $senha ."';";
	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$resultado_id = mysqli_query($link, $sql);

	if($resultado_id){
	$dados_user = mysqli_fetch_array($resultado_id);

		if(isset($dados_user['email'])){

			$_SESSION['email'] = $dados_user['email'];
			$_SESSION['id'] =  $dados_user['id'];

			header('Location: home.php?msg=1');
		}else{
			//redireciona para uma página
			header('Location: index.php?erro=1');
		}
	}else{
		echo 'Erro na execução da consulta, favor entrar em contato com o administrador do site';
	}
?>