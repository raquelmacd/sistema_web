<?php
	session_start();

	//verificar se não está logado
	if ( !isset ( $_SESSION["hqs"]["id"] ) ){
		exit;
	}

	//recuperar o email
	$email = $_GET["email"] ?? "";
	$id  = $_GET["id"] ?? "";

	//incluir o arquivo de conexao
	include "config/conexao.php";

//verificar se existe alguem com este mesmo email
	if ( ( $id == 0 ) or ( empty ( $id ) ) ) {
		//inserindo - ninguem pode ter este cpf
		$sql = "select id from cliente where email = :email limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(":email", $email);
	} else {
		//atualizando - ninguém, fora o usuário, pode ter este email
		$sql = "select id from cliente 
			where email = :email and id <> :id limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(":email", $email);
		$consulta->bindParam(":id", $id);
	}

	$consulta->execute();
	$dados = $consulta->fetch(PDO::FETCH_OBJ);

	if ( !empty ( $dados->id ) ) {
		echo "Já existe um cliente cadastrado com este e-mail";
		exit;
	}