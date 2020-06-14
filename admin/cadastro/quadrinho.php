<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
  //iniciar as variaveis
  $titulo= $data= $numero = $resumo= $valor= $tipo_id= $editora_id= $capa ="";

  //se nao existe o id
  if ( !isset ( $id ) ) $id = "";
    if ( !empty ( $id ) ) {
        include "functions.php";
  	//selecionar os dados do banco
  	$sql = "SELECT * FROM quadrinho
  		WHERE id = :id limit 1";
  	$consulta = $pdo->prepare($sql);
  	$consulta->bindParam(':id', $id); 
  	//$id - linha 255 do index.php
  	$consulta->execute();
  	$dados  = $consulta->fetch(PDO::FETCH_OBJ);

  	//separar os dados
  	$id 	= $dados->id;
  	$titulo = $dados->titulo;
    $data   = atualizarData($dados->data);
    $valor  = $dados->valor;
    $numero = $dados->numero;
    $tipo_id   = $dados->tipo_id;
    $editora_id = $dados->editora_id;
    $resumo  = $dados->resumo;
    $capa    = $dados->capa;
    $valor = number_format($valor,2,",",".");
  } 
  ?>
  <div class="container">
	<h1 class="float-left">Cadastro de Quadrinho</h1>
	<div class="float-right">
		<a href="cadastro/quadrinho" class="btn btn-success">Novo Registro</a>
		<a href="listar/quadrinho" class="btn btn-info">Listar Registros</a>
	</div>
	<div class="clearfix"></div>

	<form name="formCadastro" method="post" action="salvar/quadrinho" data-parsley-validate enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-6">            
                <label for="id">ID</label>
                <input type="text" name="id" id="id"class="form-control" readonly value="<?=$id;?>">
				<label for="tipo_id">Tipo de Quadrinho</label>
                <input type="text" name="tipo_id" id="tipo_id" class="form-control" required data-parsley-required-message="Selecione uma opção" 	value="<?=$tipo_id;?>" list="listaTipo" >
                
                <datalist id="listaTipo">
					<?php
					$sql = "select id, tipo from tipo order by tipo";
					$consulta = $pdo->prepare($sql);
					$consulta->execute();

					while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
						$id_tipo = $d->id;
						$tipo = $d->tipo;

						echo "<option value='$id_tipo - $tipo'>";
					}

					?>
                </datalist>
			</div>
			<div class="col-md-6">

                <label for="titulo">Titulo do Quadrinho</label>
                <input type="text" name="titulo" id="titulo" class="form-control" required	data-parsley-required-message="Preencha este campo, por favor"	value="<?=$titulo;?>" >
                
				<label for="editora_id">Editora do Quadrinho</label>
				<input type="text" class="form-control" list="listaEditoras" name="editora_id" id="editora_id" required data-parsley-required-message="Selecione uma opção" value="<?=$editora_id?>">
                
                <datalist id="listaEditoras">
					<?php
					$sql = "select id, nome from editora order by nome";
					$consulta = $pdo->prepare($sql);
					$consulta->execute();

					while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
						$id_editora = $d->id;
						$editora = $d->nome;

						echo "<option value='$id_editora - $editora'>";
					}

					?>
                </datalist>
			</div>	

			<div class="col-md-6">

				<label for="valor">Valor</label>
				<input type="text" name="valor" class="form-control" id="valor" value="<?=$valor;?>">
                
                <label for="numero">Número</label>
				<input type="text" name="numero" class="form-control" id="numero" value="<?=$numero;?>">

				<label for="data">Data de lançamento</label>
				<input type="text" name="data" class="form-control datepicker" id="data" value="<?=$data;?>">
                
                
			</div>
			<div class="col-md-6">
                <?php 
                //variavel r requerido se ID está vazio
                    $r = ' required data-parsley-required-message="Selecione uma foto"';
                    
                    if(!empty($id)) $r = '';
                ?>
                
				<label for="capa">Capa do Quadrinho</label>
				<input type="file" name="capa" id="capa" class="form-control" accept=".jpg" <?=$r?>>
                
                <input type="hidden" name="capa" value="<?=$capa?>" class="form-control">
                <?php  
                     
                if( !empty($capa)){
                    $foto = "<img src='../fotos/".$capa."p.jpg' alt='".$titulo."' width='150px'>";
                } else{
                    $foto = "";
                }?>
                <div><?php echo $foto ;?></div>
                
				<label for="resumo">Resumo</label>
				<textarea class="form-control" rows="8" id="resumo" name="resumo" ><?=$resumo;?></textarea>
			</div>
		</div>


		<button type="submit" class="btn btn-success margin">
			<i class="fas fa-check"></i> Gravar Dados
		</button>

	</form>
    <hr>
      <?php
      //verificar se está sendo editado - include formulario quadrinho.
      if( !empty($id)) include "cadastro/formQuadrinho.php";
      
      ?>
</div>
<script>
    $(document).ready(function() {
      $('#resumo').summernote();
      $('#valor').maskMoney({
          thousands: ".",
          decimal: ","
      });
        $("#data").inputmask("99/99/9999");
        $("#numero").inputmask("9999");
    });
</script>