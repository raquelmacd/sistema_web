<?php

    session_start();
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

    //incluir banco de dados
    include "config/conexao.php";
    $personagem = $_GET["personagem"] ?? "";
    $quadrinho = $_GET["quadrinho"] ?? "";

if( (empty($quadrinho)) or (empty($personagem)) ){
    echo '<script>alert("Erro ao ao excluir o personagem");</script>';
}

$sql = "DELETE FROM quadrinho_personagem WHERE quadrinho_id = :quadrinho_id AND personagem_id = :personagem_id ";

$consulta = $pdo->prepare($sql);
$consulta->bindParam(":quadrinho_id",$quadrinho);
$consulta->bindParam(":personagem_id",$personagem);

if (!$consulta->execute()){
    echo    '<script>alert("Erro ao excluir");</script>';
}

echo "<script>location.href='adicionarPersonagem.php?quadrinho_id=$quadrinho';</script>";