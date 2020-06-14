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
  	$id = $nome = $cpf = $datanascimento = $email = $senha = $cep = $endereco = $complemento = $bairro = $cidade_id =  $telefone = $celular =  "";
      
      //print_r($_POST);
      //print_r($_FILES);
      
  	foreach ($_POST as $key => $value) {
  		//guardar as variaveis
  		$$key = trim ( $value );
  		
  	}
    if( empty($nome) ){
        echo "<script>alert('Preencha o nome');history.back();</script>";
    } else if( empty($cpf) ){
        echo "<script>alert('Selecione o cpf');history.back();</script>";
    }  else if( empty($email) ){
        echo "<script>alert('Preencha o email');history.back();</script>";
    } else if( empty($endereco) ){
        echo "<script>alert('Preencha o endereço');history.back();</script>";
    } else if( empty($celular) ){
        echo "<script>alert('Preencha o telefone');history.back();</script>";
    } else if( empty($senha) ){
        echo "<script>alert('Preencha a senha');history.back();</script>";
    }
      
      //iniciar uma transacao
    
    $pdo->beginTransaction();
    
    $datanascimento = formatar($datanascimento);
    
    $arquivo = time()."-".$_SESSION["hqs"]["id"];
    
    
      
      if(empty($id)){
          
          $senha = crypt($senha);
          //inserir se o id estiver em branco
          $sql = "INSERT INTO cliente(nome, cpf, datanascimento, email, senha, cep, endereco, complemento, bairro, cidade_id, foto, telefone, celular) VALUES(:nome, :cpf, :datanascimento, :email, :senha, :cep, :endereco, :complemento, :bairro, :cidade_id, :foto, :telefone, :celular) ";
          $consulta = $pdo->prepare($sql);
          $consulta->bindParam(":nome", $nome);
          $consulta->bindParam(":cpf", $cpf);
          $consulta->bindParam(":datanascimento", $datanascimento);
          $consulta->bindParam(":email", $email);
          $consulta->bindParam(":senha", $senha);
          $consulta->bindParam(":cep", $cep);
          $consulta->bindParam(":endereco", $endereco);
          $consulta->bindParam(":complemento", $complemento);
          $consulta->bindParam(":bairro", $bairro);
          $consulta->bindParam(":cidade_id", $cidade_id);
          $consulta->bindParam(":foto", $arquivo);
          $consulta->bindParam(":telefone", $telefone);
          $consulta->bindParam(":celular", $celular);
          
          
      } else{
          //update se o id estiver preenchido
          //qual arquivo sera gravado
            if(!empty( $_FILES["foto"]["name"])){
                $foto = $arquivo;
            }
                    
          $sql = "UPDATE cliente SET nome= :nome, cpf = :cpf, datanascimento = :datanascimento, email = :email, senha = :senha, cep = :cep, endereco = :endereco, complemento = :complemento, bairro = :bairro, cidade_id = :cidade_id, foto = :foto, telefone = :telefone, celular = :celular WHERE id = :id ";
          $consulta = $pdo->prepare($sql);
          $consulta->bindParam(":nome", $nome);
          $consulta->bindParam(":cpf", $cpf);
          $consulta->bindParam(":datanascimento", $datanascimento);
          $consulta->bindParam(":email", $email);
          $consulta->bindParam(":senha", $senha);
          $consulta->bindParam(":cep", $cep);
          $consulta->bindParam(":endereco", $endereco);
          $consulta->bindParam(":complemento", $complemento);
          $consulta->bindParam(":bairro", $bairro);
          $consulta->bindParam(":cidade_id", $cidade_id);
          $consulta->bindParam(":foto", $foto);
          $consulta->bindParam(":telefone", $telefone);
          $consulta->bindParam(":celular", $celular);
          $consulta->bindParam(":id", $id);
          
      }
      //executar e verificar se deu certo
        if ( $consulta->execute() ) {
                //verificar se o arquivo nao está sendo enviado 
            if( empty($_FILES["foto"]["type"]) and (!empty($id)) ){
                //a capa deve estar vazia e ID nao estiver vazio
                //gravar no banco 
                $pdo->commit();
                echo "<script>alert('Registro Salvo');location.href='listar/cliente';</script>";

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
                echo "<script>alert('Registro Salvo');location.href='listar/cliente';</script>";
            }

            //erro ao gravar
            echo "<script>alert('Erro ao gravar no servidor');history.back();</script>";
            exit;
        } else {
            echo '<script>alert("Erro ao salvar");history.back();</script>';
            exit;
        }
  }