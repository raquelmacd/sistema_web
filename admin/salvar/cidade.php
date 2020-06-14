<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

  //verificar se existem dados no POST
  if ( $_POST ) {

  	//recuperar os dados do formulario
  	$id = $cidade = $estado  ="";

  	foreach ($_POST as $key => $value) {
  		//guardar as variaveis
  		$$key = trim ( $value );
  		//$id
  	}

  	//validar os campos - em branco
  	if ( empty ( $cidade ) ) {
  		echo '<script>alert("Preencha a cidade");history.back();</script>';
  		exit;
  	}

      
  	//verificar se existe um cadastro com este tipo
  	$sql = "select id from marcas 
  		where cidade = ? limit 1";
  	//usar o pdo / prepare para executar o sql
  	$consulta = $pdo->prepare($sql);
  	//passando o parametro
  	$consulta->bindParam(1, $cidade);
  	//executar o sql
  	$consulta->execute();
  	//puxar os dados (id)
  	$dados = $consulta->fetch(PDO::FETCH_OBJ);

  	//verificar se esta vazio, se tem algo é pq existe um registro com o mesmo nome
  	if ( !empty ( $dados->cidade ) ) {
  		echo '<script>alert("Já existe uma cidade com este nome");history.back();</script>';
  		exit;
  	}

  	//se o id estiver em branco - insert
  	//se o id estiver preenchido - update
  	if ( empty ( $id ) ) {
        $max = "select max(id) as maxId from cidade";
        $consulta = $pdo->prepare($max);
        $consulta->execute();
        $result = $consulta->fetch(PDO::FETCH_OBJ);
        $proximo = $result->maxId + 1 ;
        //inserir os dados no banco
  		$sql = "insert into cidade (id,cidade,estado)
  		values(?,?,?)";
  		$consulta = $pdo->prepare($sql);
        $consulta->bindParam(1,$proximo);
  		$consulta->bindParam(2, $cidade);
        $consulta->bindParam(3, $estado);


  	} else {
  		//atualizar os dados  	
  		$sql = "update cidade set cidade = ?, estado = ?  where id = ? limit 1";	
  		$consulta = $pdo->prepare($sql);
  		$consulta->bindParam(1, $cidade);
        $consulta->bindParam(2, $estado);
        $consulta->bindParam(3, $id);

  	}
  	//executar e verificar se deu certo
  	if ( $consulta->execute() ) {
  		echo '<script>alert("Registro Salvo");location.href="listar/cidade";</script>';
  	} else {
  		echo '<script>alert("Erro ao salvar");history.back();</script>';
  		exit;
  	}

  } else {
  	//mensagem de erro
  	//javascript - mensagem alert
  	//retornar hostory.back
  	echo '<script>alert("Erro ao realizar requisição");history.back();</script>';
  }