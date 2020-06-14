<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

  	//selecionar os dados do banco
  	$sql = "SELECT * FROM usuario WHERE id = ? limit 1";
  	$consulta = $pdo->prepare($sql);
  	$consulta->bindParam(1, $_SESSION["hqs"]["id"]); 
  	//$id - linha 255 do index.php
  	$consulta->execute();
  	$dados  = $consulta->fetch(PDO::FETCH_OBJ);

  	//separar os dados
  	$id 	= $dados->id;
  	$nome 	= $dados->nome;
  	$email 	= $dados->email;
    $login  = $dados->login;

?>
<div class="container">
	<h1 class="float-left">Meus Dados</h1>

	<div class="clearfix"></div>

	<form name="formCadastro" method="post" action="salvar/dados" data-parsley-validate>

		<label for="id">ID</label>
		<input type="text" name="id" id="id"
		class="form-control" readonly
		value="<?=$id;?>">

		<label for="nome">Nome do Usuário</label>
		<input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha este campo, por favor"	value="<?=$nome;?>">

		<label for="email">E-mail</label>
		<input type="email" name="email" id="email" class="form-control" required data-parsley-required-message="Preencha o e-mail"  placeholder="email@exemplo.com.br" data-parsley-type-message="Digite um e-mail válido" value="<?=$email;?>">

        <label for="login">Login</label>
		<input type="text" name="login" id="login"	class="form-control" readonly value="<?=$login;?>">
		<button type="submit" class="btn btn-success margin">
			<i class="fas fa-check"></i> Gravar Dados
		</button>

	</form>

</div> <!-- container -->