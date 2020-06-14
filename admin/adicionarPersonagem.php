<?php

    session_start();
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

    //incluir banco de dados
    include "config/conexao.php";

    $quadrinho_id = $_GET["quadrinho_id"] ?? "";
//verificar se foi post
    if($_POST){
        //inserir quadrinho
        $personagem_id = $_POST["personagem_id"] ?? "";
        $quadrinho_id = $_POST["quadrinho_id"] ?? "";
        
        //print_r($_POST);
        if( (empty($quadrinho_id)) or (empty($personagem_id)) ){
            echo '<script>alert("Erro ao salvar personagem");</script>';
        } else{
            //inserir dentro do quadrinho_personagem
            $sql = "INSERT INTO quadrinho_personagem(quadrinho_id,personagem_id)
            VALUES(:quadrinho_id, :personagem_id)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":quadrinho_id", $quadrinho_id);
            $consulta->bindParam(":personagem_id", $personagem_id);
            
            if (!$consulta->execute()){
                echo '<script>alert("Não foi possível inserir o personagem neste quadrinho");</script>';
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Personagem</title>
        <meta charset="utf-8">

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="css/style.css">

        <script src="vendor/jquery/jquery.min.js"></script>

        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

    </head>
    <body>
        <h4> Personagens deste quadrinho </h4>
        <table class="table">
        <thead>
            <tr>
                <td>Personagem</td>
                <td>Opções</td>
            </tr>
            </thead>
            <tbody>
            <?php
                $sql = "SELECT q.id qid, p.id pid, p.nome FROM `quadrinho_personagem` AS qp INNER JOIN personagem AS p ON (p.id = qp.personagem_id) INNER JOIN quadrinho AS q ON (q.id = qp.quadrinho_id) WHERE qp.quadrinho_id = :quadrinho_id ORDER BY p.nome";
                
                $consulta = $pdo->prepare($sql);
                $consulta->bindParam(":quadrinho_id", $quadrinho_id);
                $consulta->execute();
                
                while($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                    $persona = $dados->nome;
                    ?>
                <tr>
                    <td><?=$persona;?></td>
                    <td>
                    <a href="javascript:excluir(<?=$dados->pid;?>,<?=$dados->qid;?>)" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                
                <?php
                    
                }
                
                ?>
            </tbody>
        </table>
        <script>
            function excluir(personagem, quadrinho){
                
                //verificar se quer excluir
                if (confirm("Deseja realmente excluir este personagem?")){
                    //funcao para excluir o personagem
                    //direcionar para página de excluir e retornar para listagem
                    location.href="excluirPersonagem.php?personagem="+personagem+"&quadrinho="+quadrinho;
                }
            }
        </script>
    </body>
</html>