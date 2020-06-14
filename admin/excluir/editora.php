<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

  //se nao existe o id
  if ( !isset ( $id ) )     {
    echo '<script>alert("Erro ao realizar requisição");history.back();</script>';
    exit;
  }

  	//verificar se existe vinculo com quadrinho
    $sql = "select * from quadrinho 
  		where editora_id = ? limit 1";
  	$consulta = $pdo->prepare($sql);
  	$consulta->bindParam(1, $id); 
  	//$id - linha 255 do index.php
  	$consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    
    if (!empty($dados->$id)) {
      echo '<script>alert("Não é possível excluir este registro, pois existe um quadrinho relacionado com esta editora.");history.back();</script>';
      exit;
    }

   //excluir editora
    $sql = "delete from editora where id = ? limit 1";
    $verificar = $pdo->prepare($sql);
    $verificar->bindParam(1, $id);
    //verificar se executou
    if (!$verificar->execute()) {
      $erro = $verificar->errorInfo();

      //echo '<script>alert("Erro ao excluir!");history.back();</script>';
      exit;
    }

    echo "<script>location.href='listar/editora';</script>";

?>