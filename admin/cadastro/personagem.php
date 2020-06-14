<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
  //iniciar as variaveis
  $personagem= $nomeCivil = $foto = $resumo ="";

  //se nao existe o id
  if ( !isset ( $id ) ) $id = "";
    if ( !empty ( $id ) ) {
        include "functions.php";
  	//selecionar os dados do banco
  	$sql = "SELECT * FROM personagem
  		WHERE id = :id limit 1";
  	$consulta = $pdo->prepare($sql);
  	$consulta->bindParam(':id', $id); 
  	//$id - linha 255 do index.php
  	$consulta->execute();
  	$dados  = $consulta->fetch(PDO::FETCH_OBJ);

  	//separar os dados
    $id             = $dados->id;
  	$personagem 	= $dados->nome;
  	$nomeCivil      = $dados->nomecivil;
    $foto           = $dados->foto;
    $resumo         = $dados->resumo;
  } 
  ?>
<div class="container">
	<h1 class="float-left">Cadastro de Personagem</h1>
	<div class="float-right">
		<a href="cadastro/personagem" class="btn btn-success">Novo Registro</a>
		<a href="listar/personagem" class="btn btn-info">Listar Registros</a>
	</div>
	<div class="clearfix"></div>

	<form name="formCadastro" method="post" action="salvar/personagem" data-parsley-validate enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">            
                <label for="id">ID</label>
                <input type="text" name="id" id="id"class="form-control" readonly value="<?=$id;?>">
                
                <label for="nome">Nome do Personagem</label>
                <input type="text" name="nome" id="nome" class="form-control" required	data-parsley-required-message="Preencha o nome"	value="<?=$personagem;?>" >
                
                <label for="nomeCivil">Nome Civil</label>
                <input type="text" name="nomeCivil" id="nomeCivil" class="form-control" required	data-parsley-required-message="Preencha o nome civil"	value="<?=$nomeCivil;?>" >
            </div>
            <div class="col-md-12">
                <?php 
                //variavel r requerido se ID está vazio
                    $r = ' required data-parsley-required-message="Selecione uma foto"';
                    
                    if(!empty($id)) $r = '';
                ?>
                
				<label for="foto">Foto Personagem</label>
				<input type="file" name="foto" id="foto" class="form-control" accept=".jpg" <?=$r?>>
                
                <input type="hidden" name="foto" value="<?=$foto?>" class="form-control">
                <?php  
                     
                if( !empty($id)){
                    $foto = "<img src='../fotos/".$foto."p.jpg' alt='".$nomeCivil."' width='150px'>";
                } else{
                    $foto = "";
                }?>
                <div><?php echo $foto ;?></div>
                
				<label for="resumo">Resumo</label>
				<textarea class="form-control" rows="10" id="resumo" name="resumo" ><?=$resumo;?></textarea>
			</div>
		</div>
		<button type="submit" class="btn btn-success margin">
			<i class="fas fa-check"></i> Gravar Dados
		</button>
    </form>
</div>
<script>
    $(document).ready(function() {
      $('#resumo').summernote();
    });
</script>