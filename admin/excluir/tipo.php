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
      where tipo_id = ? limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id); 
    //$id - linha 255 do index.php
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    
    if (!empty($dados->$id)) {
      echo '<script>alert("Não é possível excluir este registro, pois existe uma editora relacionado com este quadrinho.");history.back();</script>';
      exit;
    }

   //excluir editora
    $sql = "delete from tipo where id = ? limit 1";
    $verificar = $pdo->prepare($sql);
    $verificar->bindParam(1, $id);
    //verificar se executou
    if (!$verificar->execute()) {
      echo '<script>alert("Erro ao excluir!");history.back();</script>';
      exit;
    }

    echo "<script>location.href='listar/tipo';</script>";

?>