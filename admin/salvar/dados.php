<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

  //verificar se existem dados no POST
  if ( $_POST ) {
    include "functions.php";
    include "config/conexao.php";
  	//recuperar os dados do formulario
  	$nome = $_POST["nome"] ?? "";
    $email= $_POST["email"] ?? "";
    
    $id = $_SESSION["hqs"]["id"] ;
      //print_r($_POST);
      //print_r($_FILES);
      
      
      if( empty($nome) ){
        echo "<script>alert('Preencha o nome');history.back();</script>";
    } else if( empty($email) ){
        echo "<script>alert('Preencha o e-mail');history.back();</script>";
      }
      
      //verificar se existe um cadastro com este nome
  	$sql = "UPDATE usuario SET nome = :nome, email = :email where id= :id  LIMIT 1";
  	//usar o pdo / prepare para executar o sql
  	$consulta = $pdo->prepare($sql);
  	//passando o parametro
  	$consulta->bindParam(":nome", $nome);
  	$consulta->bindParam(":email", $email);
    $consulta->bindParam(":id",$id);
  	//executar o sql
  	if(!$consulta->execute()){
        echo '<script>alert("Erro ao atualizar cadastro");history.back();</script>';
    }
      
      echo '<script>location.href="listar/usuarios";</script>';
  }