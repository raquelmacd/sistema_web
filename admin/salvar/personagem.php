<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

if($_POST){
    include "functions.php";
    include "config/conexao.php";
    $id= $nome= $nomeCivil = $foto = $resumo ="";
    
    foreach ($_POST as $key => $value){
        $$key = trim($value);
    }
    if( empty($nome) ){
        echo "<script>alert('Preencha o nome do personagem');history.back();</script>";
    } else if( empty($nomeCivil) ){
        echo "<script>alert('Preencha o nome civil');history.back();</script>";
    }  else if( empty($resumo) ){
        echo "<script>alert('Preencha o resumo');history.back();</script>";
    }
    
    //print_r($_POST);
    //print_r($_FILES);
    
    //iniciar uma transacao
    
    $pdo->beginTransaction();
    
    $arquivo = time()."-".$_SESSION["hqs"]["id"];
    
    if( empty($id)){
        //insert
        $sql = "INSERT INTO personagem(nome, nomecivil, foto, resumo) VALUES(:nome, :nomecivil, :foto, :resumo)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":nomecivil", $nomeCivil);
        $consulta->bindParam(":foto", $arquivo);
        $consulta->bindParam(":resumo", $resumo);
        
    }else{
        //update
        //qual arquivo sera gravado
        if(!empty( $_FILES["foto"]["name"])){
            $foto = $arquivo;
        }
        $sql = "UPDATE personagem SET nome = :nome,nomecivil = :nomecivil,foto = :foto,resumo = :resumo WHERE id = :id";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":nomecivil", $nomeCivil);
        $consulta->bindParam(":foto", $foto);
        $consulta->bindParam(":resumo", $resumo);
        $consulta->bindParam(":id", $id);
    }
    
    if( $consulta->execute()){
        //verificar se o arquivo nao está sendo enviado 
        if( empty($_FILES["foto"]["type"]) and (!empty($id)) ){
            //a foto deve estar vazia e ID nao estiver vazio
            //gravar no banco 
            

            $pdo->commit();
            echo "<script>alert('Registro Salvo');location.href='listar/personagem';</script>";
            
        }
        //veririfcar tipo imagem
        if($_FILES["foto"]["type"]  !=  "image/jpeg"){
            echo "<script>alert('Seleciona uma imagem Jpeg');history.back();</script>";
            exit;
        }
        if ( move_uploaded_file($_FILES["foto"]["tmp_name"], "../fotos/".$_FILES["foto"]["name"])){
            
            $pastaFotos = "../fotos/";
            $nome = $arquivo;
            $imagem = $_FILES["foto"]["name"];
            redimensionarImagem($pastaFotos,$imagem,$nome);
            
            //gravar no banco - se tudo deu certo
            $pdo->commit();
            echo "<script>alert('Registro Salvo');location.href='listar/personagem';</script>";
        }
        
        //erro ao gravar
        echo "<script>alert('Ocorreu um erro ao gravar no servidor');history.back();</script>";
        exit;
    }
    // echo $consulta->errorInfo()[2];
    exit;
    
}
echo '<p class="alert alert-danger>Requisição inválida</p>"';