<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
    $estado = "Selecione o estado..";
  //iniciar as variaveis
  $cidade =  "";

  //se nao existe o id
  if ( !isset ( $id ) ) $id = "";

  //verificar se existe um id
  if ( !empty ( $id ) ) {
  	//selecionar os dados do banco
  	$sql = "select * from cidade
  		where id = ? limit 1";
  	$consulta = $pdo->prepare($sql);
  	$consulta->bindParam(1, $id); 
  	//$id - linha 255 do index.php
  	$consulta->execute();
  	$dados  = $consulta->fetch(PDO::FETCH_OBJ);

  	//separar os dados
  	$id 	= $dados->id;
  	$cidade = $dados->cidade;
    $estado = $dados->estado;

  } 
?>
<div class="container">
	<h1 class="float-left">Cadastro de Cidades</h1>
	<div class="float-right">
		<a href="cadastro/cidade" class="btn btn-success">Novo Registro</a>
		<a href="listar/cidade" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<form name="formCadastro" method="post" action="salvar/cidade" data-parsley-validate>

		<label for="id">ID</label>
		<input type="text" name="id" id="id" class="form-control" readonly	value="<?=$id;?>">

		<label for="cidade">Cidade</label>
		<input type="text" name="cidade" id="cidade" class="form-control" required	data-parsley-required-message="Preencha este campo, por favor"	value="<?=$cidade;?>">
        
        <label for="estado">Estado</label>
        <input list="estados" name="estado" id="estado" class="form-control" required placeholder="<?=$estado;?>">
        <datalist id="estados">
        <?php
            $sql = "select distinct estado from cidade";
  	         $consulta = $pdo->prepare($sql);
            $consulta->execute();
            while ( $linha = $consulta->fetch(PDO::FETCH_ASSOC) ) {

                $estado = $linha["estado"];
              //montar o link
              echo "<option value='$estado'>$estado</option>";
            }
            ?>
        </datalist>

		<button type="submit" class="btn btn-success margin">
			<i class="fas fa-check"></i> Gravar Dados
		</button>

	</form>

</div> <!-- container -->