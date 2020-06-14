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
    $sql = "SELECT * FROM quadrinho_personagem 
      WHERE personagem_id = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id); 
    //$id - linha 255 do index.php
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    
    if (!empty($dados->personagem_id)) {
      echo '<script>alert("Não é possível excluir este registro, pois existe um quadrinho com este personagem.");history.back();</script>';
      exit;
    }else {
        //excluir personagem
        $sql = "DELETE FROM personagem WHERE id = ? LIMIT 1";
        $verificar = $pdo->prepare($sql);
        $verificar->bindParam(1, $id);
        //verificar se executou
        if (!$verificar->execute()) {
           // echo $consulta->errorInfo()[2];
            //echo $verificar->errorInfo()[2];
          echo '<script>alert("Erro ao excluir!");history.back();</script>';
          exit;
        }
        
    }

    
    echo "<script>location.href='listar/personagem';</script>";
