<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

if($_POST){
    include "functions.php";
    include "config/conexao.php";
    $id= $titulo= $data= $numero = $resumo= $valor= $tipo_id= $editora_id=  "";
    
    foreach ($_POST as $key => $value){
        $$key = trim($value);
    }
    if( empty($titulo) ){
        echo "<script>alert('Preencha o título');history.back();</script>";
    } else if( empty($tipo_id) ){
        echo "<script>alert('Selecione o tipo');history.back();</script>";
    }  else if( empty($valor) ){
        echo "<script>alert('Preencha o valor');history.back();</script>";
    } else if( empty($editora_id) ){
        echo "<script>alert('Selecione a editora');history.back();</script>";
    } else if( empty($numero) ){
        echo "<script>alert('Preencha o numero');history.back();</script>";
    } else if( empty($data) ){
        echo "<script>alert('Preencha a data');history.back();</script>";
    } else if( empty($_FILES) ){
        echo "<script>alert('Selecione a capa');history.back();</script>";
    }
    
    //iniciar uma transacao
    
    $pdo->beginTransaction();
    
    $data = formatar($data);
    
    $numero = retirar($numero);
    
    $valor = formatarValor($valor);
    
    
    $arquivo = time()."-".$_SESSION["hqs"]["id"];
    
    if(empty($id)){
        //inserir
        $sql= "INSERT INTO quadrinho(titulo,numero,data,capa, resumo,valor,tipo_id,editora_id) values(:titulo,:numero,:data,:capa,:resumo,:valor,:tipo_id,:editora_id)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':titulo',$titulo);
        $consulta->bindParam(':numero',$numero);
        $consulta->bindParam(':data',$data);
        $consulta->bindParam(':capa',$arquivo);
        $consulta->bindParam(':resumo',$resumo);
        $consulta->bindParam(':valor',$valor);
        $consulta->bindParam(':tipo_id',$tipo_id);
        $consulta->bindParam(':editora_id',$editora_id);
        
    } else{
        //qual arquivo sera gravado
        if(!empty( $_FILES["capa"]["name"])){
            $capa = $arquivo;
        }
        //update
        $sql= "UPDATE quadrinho SET titulo = :titulo, data = :data, capa = :capa, resumo = :resumo, valor = :valor, tipo_id = :tipo_id, editora_id = :editora_id  WHERE id = :id";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':titulo',$titulo);
        $consulta->bindParam(':data',$data);
        $consulta->bindParam(':capa',$capa);
        $consulta->bindParam(':resumo',$resumo);
        $consulta->bindParam(':valor',$valor);
        $consulta->bindParam(':tipo_id',$tipo_id);
        $consulta->bindParam(':editora_id',$editora_id);
        $consulta->bindParam(':id',$id);
    }
    
    if($consulta->execute()){
        //verificar se o arquivo nao está sendo enviado 
        if( empty($_FILES["capa"]["type"]) and (!empty($id)) ){
            //a capa deve estar vazia e ID nao estiver vazio
            //gravar no banco 
            $pdo->commit();
            echo "<script>alert('Registro Salvo');location.href='listar/quadrinho';</script>";
            
        }
        //veririfcar tipo imagem
        if($_FILES["capa"]["type"]  !=  "image/jpeg"){
            echo "<script>alert('Seleciona uma imagem Jpeg');history.back();</script>";
            exit;
        }
        if ( move_uploaded_file($_FILES["capa"]["tmp_name"], "../fotos/".$_FILES["capa"]["name"])){
            
            $pastaFotos = "../fotos/";
            $nome = $arquivo;
            $imagem = $_FILES["capa"]["name"];
            redimensionarImagem($pastaFotos,$imagem,$nome);
            
            //gravar no banco - se tudo deu certo
            $pdo->commit();
            echo "<script>alert('Registro Salvo');location.href='listar/quadrinho';</script>";
        }
        
        //erro ao gravar
        echo "<script>alert('Erro ao gravar no servidor');history.back();</script>";
        exit;
    }
    
    //echo consulta->errorInfo()[2];
    exit;
}

echo '<p class="alert alert-danger>Requisição inválida</p>"';